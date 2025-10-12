<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Product;

interface ProductRepository
{
    /**
     * @param Product{Id:int,name:string,price:float} $product
     */

    public function save(Product $product): Product;

    /**
     * @return Product[]
     */

    public function findAll(): array;

    /**
     * @return int
     */

    public function getLastId(): int;
}