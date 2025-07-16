<?php

declare(strict_types=1);

session_start();

require_once 'vendor/autoload.php';

require_once 'Service/ApiService.php';

use App\Service\ApiService;

$apiService = new ApiService();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = $apiService->rodarEtl();

    if ($response === null) {
        $_SESSION['error_message'] = "A API de ETL retornou um erro.";
    } else {
        $_SESSION['success_message'] = $response['message'] ?? 'Dados atualizados com sucesso!';
    }
    header('Location: index.php');
    exit();
}

if (isset($_SESSION['error_message'])) {
    $errorMessage = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}
if (isset($_SESSION['success_message'])) {
    $successMessage = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

$data = $apiService->pegaPlayersDoBancoDeDados();

require 'view.php';