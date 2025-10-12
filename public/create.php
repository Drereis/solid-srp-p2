<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Application\ProductService;
use App\Domain\Product;
use App\Infra\FileProductRepository;
use App\Infra\SimpleProductValidator;

$filePath = __DIR__ . '/../storage/products.txt';

$repository = new FileProductRepository($filePath);
$validator = new SimpleProductValidator(); 
$service = new ProductService($repository, $validator);
$message = '';
$errors = [];
$formData = $_POST;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $service->createProduct($_POST);
    if ($result instanceof Product) {
      
        http_response_code(201); 
        $message = "Produto '{$result->getName()}' cadastrado com sucesso (ID: {$result->getId()}).";
        $formData = []; 
    } else {
        http_response_code(422); 
        $errors = $result;
        $message = "Falha ao cadastrar produto. Verifique os campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Processamento de Cadastro</title>
    <style> .error { color: red; display: block; font-weight: bold; } </style>
</head>
<body>
    <?php if ($message): ?>
        <p style="color: <?= empty($errors) ? 'green' : 'red'; ?>; font-weight: bold;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <?php if (!empty($errors)):?>
        <form action="create.php" method="POST">
            <div>
                <label for="name">Nome do Produto:</label>
                <input type="text" id="name" name="name" 
                       value="<?= htmlspecialchars($formData['name'] ?? '') ?>" required>
                <?php if (isset($errors['name'])): ?>
                    <span class="error"><?= htmlspecialchars($errors['name']) ?></span>
                <?php endif; ?>
            </div>
            <div>
                <label for="price">Preço:</label>
                <input type="text" id="price" name="price" 
                       value="<?= htmlspecialchars($formData['price'] ?? '') ?>" required>
                <?php if (isset($errors['price'])): ?>
                    <span class="error"><?= htmlspecialchars($errors['price']) ?></span>
                <?php endif; ?>
            </div>
            <button type="submit">Cadastrar Novamente</button>
        </form>
    <?php endif; ?>
    <p><a href="products.php">Ver lista de Produtos</a> | <a href="index.php">Voltar ao Formulário</a></p>
</body>
</html>