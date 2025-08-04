<?php
namespace App\Service;

use GuzzleHttp\Client;
use Exception;
use PDO;

final class ApiService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function rodarEtl(): ?array
    {
        try {
            $response = $this->client->request('POST', 'http://python-api:8000/etl');
            $body = $response->getBody()->getContents();
            return json_decode($body, true);
        } catch (Exception $e) {
            error_log("Erro ao chamar a API de ETL: " . $e->getMessage());
            return null;
        }
    }

    // Dentro da classe ApiService, substitua o método antigo por este:
public function pegaPlayersDoBancoDeDados(string $searchTerm = ''): ?array
{
    try {
        $url = 'http://python-api:8000/players';

        // Se um termo de busca foi fornecido, adiciona-o à URL
        if (!empty($searchTerm)) {
            $url .= '?search_name=' . urlencode($searchTerm);
        }

        $response = $this->client->request('GET', $url);
        $body = $response->getBody()->getContents();
        return json_decode($body, true);

    } catch (Exception $e) {
        error_log("Erro ao buscar dados da API de players: " . $e->getMessage());
        return null;
    }
}

    public function getTeamPerformance(): ?array
    {
        try {
            $response = $this->client->request('GET', 'http://python-api:8000/teams/performance');
            $body = $response->getBody()->getContents();
            return json_decode($body, true);
        } catch (Exception $e) {
            error_log("Erro ao buscar dados da API de performance de times: " . $e->getMessage());
            return null;
        }
    }
}