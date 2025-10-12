<?php

declare(strict_types=1);

namespace app\Domain;

interface ProductValidator
{
    /**
     * @param array{int?:id,name?:string,price:float}$input
     * @param array|bool
     */

    public function validate(array $input): array|bool;
}