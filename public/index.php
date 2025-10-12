<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produto | SRP Demo</title>
    <style>
        body { font-family: sans-serif; }
        label { display: block; margin-top: 15px; }
        input[type="text"] { width: 300px; padding: 5px; margin-top: 5px; }
        button { padding: 8px 15px; margin-top: 15px; }
    </style>
</head>
<body>
    <h1>Cadastro de Produto</h1>
    
    <form action="create.php" method="POST">
        <div>
            <label for="name">Nome do Produto:</label>
            <input type="text" id="name" name="name" required>
        </div>
        
        <div>
            <label for="price">Preço:</label>
            <input type="text" id="price" name="price" required>
        </div>
        
        <button type="submit">Cadastrar</button>
    </form>
    
    <p style="margin-top: 20px;">
        <a href="products.php">Ver Listagem de Produtos</a>
    </p>
</body>
</html>