<?php
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (class_exists('GuzzleHttp\Client')) {
        $client = new GuzzleHttp\Client();
        $api_response_message = '';
        $status_class = '';

        try {
    $response = $client->request('GET', 'http://python-api:8000');
    $body = $response->getBody();
    $data = json_decode($body, true);

    $status_class = 'response-success';

    $formatted_data = print_r($data, true);

    $api_response_message = "Conexão bem-sucedida! Dados recebidos:\n\n" . $formatted_data;

        } catch (\Exception $e) {
            $status_class = 'response-error';
            $api_response_message = "Falha na conexão com a API Python.\nErro: " . $e->getMessage();
        }
    } else {
        $status_class = 'response-error';
        $api_response_message = "Erro de configuração: A biblioteca Guzzle não foi encontrada. Execute 'composer require guzzlehttp/guzzle' no contêiner php-app.";
    }
}

require 'view.php';