<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\ProductRepository;
use App\Domain\ProductValidator;

class ProductService
{
    private ProductRepository $repository;
    private ProductValidator $validator;

    public function __construct(ProductRepository $repository, ProductValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * @param array{Id?:int,name?:string?:,price?:float,} $input
     */

    public function generateNextId(): int
    {
        return count($this->product) + 1;
    }

    public function createProduct(array $input): bool
    {
        $errors = $this->validator->validate($input);
        if (!empty($errors)) {
            return false;
        }

        $product = [
            'name' => isset($input['name']) ? (string) $input['name'] : 'Nome do produto',
            'price' => (int) ($input['price'] ?? ''),
        ];

        $this->repository->save($product);
        return true;
    }
}

