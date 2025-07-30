<?php

namespace App\Service;

use GuzzleHttp\Client;
use Exception;
use PDO;

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
    public function rodarEtl(): ?array
    {
        try {
            $response = $this->client->request('POST', 'http://python-api:8000/etl');

            $body = $response->getBody()->getContents();

            return json_decode($body, true);

        } catch (Exception $e) {
            error_log("Erro ao chama a API de ETL:" . $e->getMessage());
            return null;
        }
    }

    public function pegaPlayersDoBancoDeDados(): ?array
    {
        try {
            $response = $this->client->request('GET', 'http://python-api:8000/players');
            
            $body = $response->getBody()->getContents();
            
            return json_decode($body, true);

        } catch (Exception $e) {
            error_log("Erro ao buscar dados da API de players: " . $e->getMessage());
            return null;
        }
    }
}
