<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use App\Storage\FileStorage;
use App\Service\DataProcessor;

header("Content-Type: application/json");

try {
    $inputData = json_decode(file_get_contents("php://input"), true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new \Exception("Invalid JSON format.");
    }

    $storage = new FileStorage(__DIR__ . '/var/data/storage.json');
    $processor = new DataProcessor($storage);

    $processor->process($inputData);

    echo json_encode(['status' => 'OK']);
} catch (\Exception $e) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
