<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';
require_once 'Service/ApiService.php';

use App\Service\ApiService;

$apiService = new ApiService();
$teamData = $apiService->getTeamPerformance(); 

require 'teams-view.php';