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

    public function createProduct(array $input): bool
}

