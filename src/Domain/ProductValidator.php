<?php

declare(strict_types=1);

namespace app\Domain;

final class ProductValidator
{
    /**
     * @param array{int?:id,name?:string,price:float}$input
     */

    public function validate(array $input): array
    {
        $errors = [];

        $name = $input['name'] ?? ''; 
        $price = $input['price'] ?? '';

        if ((strlen($name) > 2) && (strlen($name) <= 100)) {
            $errors[] = 'O nome é invalido (minimo de 2 caracteres e máximo de 100 caracteres)';    
        }

        if (is_numeric($price) && ($price >= 0 )) {
            $errors[] = 'O preco é invalido';
        }

        return $errors;
    }
}