<?php
/**
 * @author Bartłomiej Olewiński <bartlomiej.olewinski@gmail.com>
 */

namespace App\Service;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;

class ExchangeService implements ExchangeServiceInterface
{
    const API_URL = "https://api.exchangeratesapi.io";
    const PRECISION = 2;

    /**
     * @var ClientInterface
     */
    protected $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $from
     * @param string $to
     * @param float $amount
     * @return float
     * @throws GuzzleException
     * @throws \Exception
     */
    public function exchange(string $from, string $to, float $amount): float
    {
        $from = strtoupper($from);
        $to = strtoupper($to);
        $request = new Request(
            'GET',
            $this->getBaseUri()."/latest?base={$from}&symbols={$to}"
        );
        try {
            $response = $this->client->send($request);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $this->setForwardErrorCode($e->getCode()), $e);
        }

        $content = json_decode( $response->getBody()->getContents());
        $rate = $content->rates->{$to};
        $result = $amount * $rate;
        return round($result, self::PRECISION);
    }

    function getBaseUri(): string
    {
        return self::API_URL;
    }

    protected function setForwardErrorCode(int $code)
    {
        $digit = (int)substr($code, 0,1);
        switch ($digit) {
            case 5:
                return 424; //dependency/3rd party app error
                break;

            case 4:
                return $code; //propagate forward given 4xx error
                break;

            default:
                return 500;
                break;
        }
    }
}