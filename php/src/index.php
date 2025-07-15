<?php
declare(strict_types=1);

require_once 'vendor/autoload.php';

require_once 'Service/ApiService.php';

use App\Service\ApiService;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $apiService = new ApiService();
    $data = $apiService->getPlayerData();

    if($data === null) {
        $errorMessage = "A API retornou um erro, arquivo está com coluna faltando";
    } else {
        $successMessage = $data['message'];
    }
}

require 'view.php';