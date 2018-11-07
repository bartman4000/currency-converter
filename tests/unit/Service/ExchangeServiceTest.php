<?php
/**
 * @author Bartłomiej Olewiński <bartlomiej.olewinski@gmail.com>
 */

namespace App\Tests\unit\Service;

use App\Service\ExchangeService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ExchangeServiceTest extends TestCase
{
    /**
     * @var Client|\PHPUnit_Framework_MockObject_MockObject
     */
    private $clientMock;

    public function setUp()
    {
        /** @var Client|\PHPUnit_Framework_MockObject_MockObject $clientMock  */
        $this->clientMock = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testSetForwardErrorCode()
    {
        $service = new ExchangeService($this->clientMock);
        $this->assertEquals(500, $service->setForwardErrorCode(0));
        $this->assertEquals(404, $service->setForwardErrorCode(404));
        $this->assertEquals(424, $service->setForwardErrorCode(500));
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testExchange()
    {
        $request = new Request(
            'GET',
            "https://api.exchangeratesapi.io/latest?base=RUB&symbols=PLN"
        );

        $mockJson = '{
    "date": "2018-11-06",
    "rates": {
        "PLN": 0.057
    },
    "base": "RUB"
}';

        $response = new Response(200, [], $mockJson);

        $this->clientMock->expects(self::exactly(1))->method('send')->with($request)->willReturn($response);
        $service = new ExchangeService($this->clientMock);

        $result = $service->exchange('RUB', 'PLN', 100);
        $this->assertEquals(5.7, $result);
    }
}
