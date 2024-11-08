<?php

declare(strict_types=1);

use App\Service\DataProcessor;
use App\Storage\StorageInterface;
use PHPUnit\Framework\TestCase;

class DataProcessorTest extends TestCase
{
    public function testProcessWithValidData()
    {
        $mockStorage = $this->createMock(StorageInterface::class);
        $mockStorage->expects($this->once())
            ->method('save')
            ->with($this->equalTo(['source' => 'example', 'payload' => ['key' => 'value']]));

        $processor = new DataProcessor($mockStorage);
        $data = [
            'source' => 'example',
            'payload' => ['key' => 'value']
        ];

        $processor->process($data);
    }

    public function testProcessRemovesSensitiveData()
    {
        $mockStorage = $this->createMock(StorageInterface::class);
        $mockStorage->expects($this->once())
            ->method('save')
            ->with($this->equalTo([
                'source' => 'example',
                'payload' => ['email' => '_SENSITIVE_DATA_REMOVED_']
            ]));

        $processor = new DataProcessor($mockStorage);
        $data = [
            'source' => 'example',
            'payload' => ['email' => 'user@example.com']
        ];

        $processor->process($data);
    }

    public function testProcessThrowsExceptionOnInvalidData()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid data: 'source' or 'payload' missing.");

        $mockStorage = $this->createMock(StorageInterface::class);
        $processor = new DataProcessor($mockStorage);

        $data = [
            'payload' => ['key' => 'value']
        ];

        $processor->process($data);
    }
}
