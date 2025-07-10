<?php
declare(strict_types=1);

require_once 'vendor/autoload.php';

require_once 'Service/ApiService.php';

use App\Service\ApiService;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $apiService = new ApiService();

    $data = $apiService->getPlayerData();
}

require 'view.php';