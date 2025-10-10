<?php

declare(strict_types=1);

namespace App\Domain;

interface ProductRepository
{
    /**
     * @param array{Id:int,name:string,price:float} $product
     */

    public function save(array $product): void;
}