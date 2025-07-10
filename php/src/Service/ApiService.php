<?php

namespace App\Service;

use GuzzleHttp\Client;
use Exception; 

final class ApiService
{
    /**
     * @var Client 
     */
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @return array|null 
     */
    public function getPlayerData(): ?array
    {
        try {
            $response = $this->client->request('GET', 'http://python-api:8000');

            $body = $response->getBody()->getContents();

            return json_decode($body, true);

        } catch (Exception $e) {

            return null;
        }
    }
}