<?php

namespace App\WebClients\Bitcoin;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class BitcoinWebClient implements IBitcoinWebClient
{
    private HttpClientInterface $client;
    private string $url;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
        $this->url = "https://api.coincap.io/v2/assets/bitcoin";
    }

    public function recupererPrixBitcoin(): float
    {
        return $this->functionRecupererPrixCrypto('bitcoin');
    }

    public function functionRecupererPrixCrypto(string $crypto): float
    {
        $response = $this->client->request('GET', "https://api.coincap.io/v2/assets/$crypto");
        $content = $response->toArray();
        return $content['data']['priceUsd'];
    }
}

