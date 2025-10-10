<?php

declare(strict_types=1);

namespace app\Domain;

final class ProductValidator
{
    /**
     * @param array{int?:id,name?:string,price:float}$input
     */

    public function validate(array $product): array
    {
        $errors = [];
    }
}