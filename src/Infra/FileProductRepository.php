<?php

declare(strict_types=1);

namespace App\Infra;


use App\Domain\Product;
use App\Domain\ProductRepository;
use SplFileObject;

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


    public function save(Product $product): Product
    {
        $newId = $this->getLastId() + 1;
        $savedProduct = new Product($newId, $product->getName(), $product->getPrice());

        $data = json_encode($savedProduct->toArray(), JSON_UNESCAPED_UNICODE);
        file_put_contents($this->filePath, $data . "\n", FILE_APPEND | LOCK_EX);

        return $savedProduct;
    }

    public function findAll(): array
    {
        $products = [];
        if(!file_exists($this->filePath)) {
            return $products;
        }

        $file = new SplFileObject($this->filePath, 'r');

        while (!$file->eof()) {
            $line = trim($file->fgets());
            if ($line) {
                $data = json_decode($line, true);
                if ($data && isset($data['id'], $data['name'],$data['price'])) {
                    $products[] = Product::fromArray($data);
                }
            }
        }

        return $products;
    }

    public function getLastId(): int
    {
        $products = $this->findAll();

        if (empty($products)) {
            return 0;
        }

        $lastProduct = end($products);
        return $lastProduct->getId() ?? 0;
    }
}

