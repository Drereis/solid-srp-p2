<?php

declare(strict_types=1);
    
namespace App\Application;

use App\Domain\ProductRepository;
use App\Domain\ProductValidator;
use App\Domain\Product;

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
     * @param array{name?:string?:,price?:float,} $input
     * @return Product|array
     */

    public function createProduct(array $input): Product|array
    {
        $validationResult = $this->validator->validate($input);

        if (is_array($validationResult)) {
            return $validationResult;
        }

        $name = trim($input['name']);
        $price = (float)str_replace(',', '.' , (string)$input['price']);
        $product = new Product(null, $name, $price);
        $saveProduct = $this->repository->save($product);

        return $saveProduct;
    }
    
    /**
     * @return Product[]
     */

    public function ListProducts(): array
    {
        return $this->repository->findAll();
    }
}

