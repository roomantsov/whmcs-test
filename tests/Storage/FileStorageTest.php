<?php

declare(strict_types=1);

use App\Storage\FileStorage;
use PHPUnit\Framework\TestCase;

class FileStorageTest extends TestCase
{
    private string $filePath;

    protected function setUp(): void
    {
        $this->filePath = __DIR__ . '/test_storage.json';
    }

    protected function tearDown(): void
    {
        if (file_exists($this->filePath)) {
            unlink($this->filePath);
        }
    }

    public function testSaveWritesDataToFile()
    {
        $storage = new FileStorage($this->filePath);
        $data = ['key' => 'value'];
        $storage->save($data);

        $this->assertFileExists($this->filePath);

        $fileContents = file_get_contents($this->filePath);
        $decodedData = json_decode($fileContents, true);

        $this->assertEquals($decodedData, [$data]);
    }

    public function testSaveWritesDataToFileTwice()
    {
        $storage = new FileStorage($this->filePath);
        $data = ['key' => 'value'];
        $storage->save($data);
        $storage->save($data);

        $this->assertFileExists($this->filePath);

        $fileContents = file_get_contents($this->filePath);
        $decodedData = json_decode($fileContents, true);

        $this->assertEquals($decodedData, [$data, $data]);
    }
}
