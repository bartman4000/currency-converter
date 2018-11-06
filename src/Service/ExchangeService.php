<?php
/**
 * @author Bartłomiej Olewiński <bartlomiej.olewinski@gmail.com>
 */

namespace App\Service;

use GuzzleHttp\ClientInterface;
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function exchange(string $from, string $to, float $amount): float
    {
        $from = strtoupper($from);
        $to = strtoupper($to);
        $request = new Request(
            'GET',
            $this->getBaseUri()."/latest?base={$from}&symbols={$to}"
        );
        $response = $this->client->send($request);
        $content = json_decode( $response->getBody()->getContents());
        $rate = $content->rates->{$to};
        $result = $amount * $rate;
        return round($result, self::PRECISION);
    }

    function getBaseUri(): string
    {
        return self::API_URL;
    }
}