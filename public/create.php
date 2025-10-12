<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Infra\FileProductRepository;
use App\Domain\ProductValidator;
use App\Application\ProductService;

$file = __DIR__ . '/../storage/products.txt';

$service = new ProductService( new FileProductRepository($file), new ProductValidator());

$response = $service->createProduct($_POST);

http_response_code($response ? 201 : 422);

echo $response ? 'Produto criado com sucesso' : 'Falha ao criar produto novo';