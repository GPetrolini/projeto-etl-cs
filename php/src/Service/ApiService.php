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
            $response = $this->client->request('GET', 'http://python-api:8000');

            $body = $response->getBody()->getContents();

            return json_decode($body, true);

        } catch (Exception $e) {
            error_log("Erro ao chama a API de ETL:" . $e->getMessage());
            return null;
        }
    }

    public function pegaPlayersDoBancoDeDados(): ?array
    {
        $host = $_ENV['DB_HOST'] ?? 'db';
        $dbNome = $_ENV['MYSQL_DATABASE'] ?? 'cs_data';
        $usuario = 'root';
        $senha = $_ENV['DB_PASSWORD'] ?? '';
        $dsn = "mysql:host={$host};dbname={$dbNome};charset=utf8";

        try {
            $pdo = new PDO ($dsn, $usuario, $senha);
            $stmt = $pdo->query("SELECT * FROM player_stats ORDER BY impact_score DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Erro de conexão com o banco: " . $e->getMessage());
            return [];
        }
    }
}