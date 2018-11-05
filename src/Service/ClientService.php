<?php
/**
 * @author Bartłomiej Olewiński <bartlomiej.olewinski@gmail.com>
 */

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ClientService implements ClientInterface, ExchangeClientInterface
{
    /**
     * @var ClientInterface
     */
    protected $httpClient;

    public function __construct()
    {
         $config = [
            'base_uri' => 'https://api.exchangeratesapi.io',
            'headers'  => [
                'Content-Type' => 'application/json; charset=UTF-8'
            ]
        ];
        $this->httpClient = new Client($config);
    }

    /**
     * Sends a PSR-7 request and returns a PSR-7 response.
     *
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface If an error happens while processing the request.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        return $this->httpClient->send($request);
    }

    /**
     * @param string $from
     * @param string $to
     * @return float
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function getRate(string $from, string $to): float
    {
        $request = new Request('GET', "/latest?base={$from}&symbols={$to}");
        $response = $this->sendRequest($request);
        $content = json_decode( $response->getBody()->getContents());
        return (float) $content->rates->{$to};
    }
}