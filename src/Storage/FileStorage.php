<?php

declare(strict_types=1);

namespace App\Storage;

class FileStorage implements StorageInterface {
    public function __construct(protected string $filePath) {}

    public function save(array $data): void
    {
        $currentData = [];

        if (file_exists($this->filePath)) {
            $currentData = json_decode(file_get_contents($this->filePath), true) ?? [];
        }

        $currentData[] = $data;

        file_put_contents($this->filePath, json_encode($currentData, JSON_PRETTY_PRINT));
    }
}
