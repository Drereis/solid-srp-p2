<?php

declare(strict_types=1);

namespace App\Infra;

use App\Domain\ProductValidator;

final class SimpleProductValidator implements ProductValidator
{
    public function validate(array $input): array|bool
    {
        $errors = [];

        $name = trim($input['name'] ?? '');
        if (empty($name)) {
            $errors['name'] =  'O nome do produto é obrigatório.'; 
        } elseif (strlen($name) < 2 || strlen($name) > 100) {
            $errors['name'] = 'O nome deve ter entre 2 e 100 caracteres.';
        } 

        $priceInput = $input['price'] ?? null;
        if (!isset($priceInput) || $priceInput === '') {
            $errors['price'] = 'O preço é obrigatório.';
        } else {
            $price = str_replace(',' ,'.', (string)$priceInput);

            if (!is_numeric($price)) {
                $errors['price'] = 'o preço é invalido (deve ser numerico).';
            } else {
                $priceFloat = (float)$price;
                if ($priceFloat < 0) {
                    $errors['price'] = 'O preço não pode ser negativo';
                }
            }
        }

        return empty($errors) ? true : $errors;
    } 
}