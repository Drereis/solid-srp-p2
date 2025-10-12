<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Application\ProductService;
use App\Infra\FileProductRepository;
use App\Infra\SimpleProductValidator; 


$filePath = __DIR__ . '/../storage/products.txt';

$repository = new FileProductRepository($filePath);
$validator = new SimpleProductValidator(); 
$service = new ProductService($repository, $validator);

$products = $service->listProducts(); 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Listagem de Produtos (SRP)</title>
    <style>
        table { width: 60%; border-collapse: collapse; margin-top: 20px;}
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h1>Listagem de Produtos</h1>
    <p><a href="index.php">Cadastrar Novo Produto</a></p>
    <?php if (empty($products)): ?>
        <p>Nenhum produto cadastrado.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Preço</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars((string)$product->getId()) ?></td>
                        <td><?= htmlspecialchars($product->getName()) ?></td>
                        <td>R$ <?= number_format($product->getPrice(), 2, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>