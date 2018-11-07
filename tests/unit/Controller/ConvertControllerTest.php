<?php
/**
 * @author Bartłomiej Olewiński <bartlomiej.olewinski@gmail.com>
 */

namespace App\Tests\unit\Controller;

use App\Controller\Api\ConvertController;
use App\Service\ExchangeService;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class ConvertControllerTest extends TestCase
{
    public function testIndex()
    {
        /** @var Request|\PHPUnit_Framework_MockObject_MockObject $requestMock  */
        $requestMock = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();

        $requestMock->query = new ParameterBag([
            'from' => 'rub',
            'to' => 'pln',
            'amount' => '100',
        ]);

        /** @var Client|\PHPUnit_Framework_MockObject_MockObject $clientMock  */
        $clientMock = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var ExchangeService|\PHPUnit_Framework_MockObject_MockObject $serviceMock  */
        $serviceMock = $this->getMockBuilder(ExchangeService::class)
            ->disableOriginalConstructor()
            ->setConstructorArgs([$clientMock])
            ->getMock();
        $serviceMock ->expects(self::exactly(1))->method('exchange')->with('rub', 'pln', 100)->willReturn(6);

        /** @var LoggerInterface|\PHPUnit_Framework_MockObject_MockObject $loggerMock  */
        $loggerMock = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $controller = new ConvertController();
        $response = $controller->index($requestMock, $serviceMock, $loggerMock);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('{"from":"rub","to":"pln","amount":100,"result":6}', $response->getContent());
    }
}
