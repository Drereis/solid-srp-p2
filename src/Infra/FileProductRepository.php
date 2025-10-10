<?php

declare(strict_types=1);

namespace App\Infra;

use App\Domain\ProductRepository;

final class FileProductRepository implements ProductRepository
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
        $dir = dirname($this->filePath);

        if (!is_dir($dir)) {
            mkdir($dir, 0777, recursive:true);
        }
        if (!file_exists($this->filePath)) {
            touch($this->filePath);
        }
    }

    /**
     * @param array{Id:int,name:string,price:float} $product
     */

    public function save(array $product): void
    {
        file_put_contents(
            $this->filePath,
            json_encode($product, JSON_UNESCAPED_UNICODE) . PHP_EOL,
            FILE_APPEND
        );
    }
}

