<?php

declare(strict_types=1);

namespace App\Service;

use App\Storage\StorageInterface;

class DataProcessor {
    public function __construct(protected StorageInterface $storage) {}

    public function process(array $requestData): void
    {
        if (empty($requestData['source']) || empty($requestData['payload'])) {
            throw new \InvalidArgumentException("Invalid data: 'source' or 'payload' missing.");
        }

        $payload = $requestData['payload'];

        if (isset($payload['email'])) {
            $payload['email'] = '_SENSITIVE_DATA_REMOVED_';
        }

        $this->storage->save(['source' => $requestData['source'], 'payload' => $payload]);
    }
}
