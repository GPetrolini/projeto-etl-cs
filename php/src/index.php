<?php

declare(strict_types=1);

session_start();

require_once 'vendor/autoload.php';
require_once 'Service/ApiService.php';

use App\Service\ApiService;

$apiService = new ApiService();
$errorMessage = null;
$successMessage = null;
$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = $apiService->rodarEtl();

    if ($response === null) {
        $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'A API de ETL retornou um erro.'];
    } else {
        $freshData = $apiService->pegaPlayersDoBancoDeDados();
        $_SESSION['flash_message'] = [
            'type' => 'success', 
            'text' => $response['message'] ?? 'Dados atualizados!',
            'data' => $freshData
        ];
    }
    
    header('Location: index.php');
    exit();
}

if (isset($_SESSION['flash_message'])) {
    if ($_SESSION['flash_message']['type'] === 'error') {
        $errorMessage = $_SESSION['flash_message']['text'];
    } else {
        $successMessage = $_SESSION['flash_message']['text'];
        $data = $_SESSION['flash_message']['data'];
    }
    unset($_SESSION['flash_message']);
} else {
    $data = $apiService->pegaPlayersDoBancoDeDados();
}

require 'view.php';
