# Solid SRP P2 - Products Management System

Este projeto demonstra a aplicação do Princípio da Responsabilidade Única (SRP), PSR-4 e organização em camadas em PHP puro, utilizando Composer e XAMPP. O sistema permite cadastro e listagem de produtos, persistindo dados em arquivo texto JSON por linha.

## Objetivos de Aprendizagem

- Aplicar SRP: separar validação, orquestração e persistência.
- Usar Composer e autoload PSR-4.
- Organizar o projeto em camadas: Application, Domain/Contracts, Infra, public, storage.
- Implementar cadastro e listagem de produtos usando arquivo como persistência.

## Estrutura de Diretórios (PSR-4)

```
products-srp-demo/
├─ composer.json
├─ vendor/
├─ src/
│ ├─ Contracts/ # ou Domain/ se preferir
│ │ ├─ ProductRepository.php # contrato
│ │ └─ ProductValidator.php # contrato
│ ├─ Application/
│ │ ├─ ProductService.php # orquestra cadastro e listagem
│ ├─ Domain/
│ │ └─ SimpleProductValidator.php # implementação do contrato de validação
│ └─ Infra/
│ └─ FileProductRepository.php # implementação do repositório
├─ public/
│ ├─ index.php # formulário de cadastro
│ ├─ create.php # recebe POST e chama o service
│ └─ products.php # lista produtos (somente leitura)
└─ storage/
 └─ products.txt # JSON por linha
```

## Requisitos Técnicos

- PHP ( Mas vc sabia disso )
- Composer
- XAMPP (Ou derivados) servindo via `http://localhost/products-srp-demo/public/`

## Instalação e Configuração

1. Clone ou copie o projeto para o diretório do XAMPP: `htdocs/products-srp-demo/`
2. Execute `composer install` para instalar dependências e configurar autoload PSR-4.
3. Certifique-se de que o diretório `storage/` tenha permissões de escrita.
4. Inicie o Apache no XAMPP.

## Uso

### Cadastro de Produto
- Acesse `http://localhost/products-srp-demo/public/index.php`
- Preencha o formulário com nome e preço.
- Clique em "Cadastrar".

### Listagem de Produtos
- Acesse `http://localhost/products-srp-demo/public/products.php`
- Visualize a tabela com produtos cadastrados.

## Regras de Negócio

- **Entidade Produto**: `{ id: int, name: string, price: float }`
- ID incremental simples (calculado ao inserir, começando em 1 se arquivo vazio).
- Name: não vazio, 2-100 caracteres.
- Price: numérico, >= 0.
- Persistência em `storage/products.txt` com JSON por linha.

## Fluxo entre Classes

1. `public/create.php` recebe POST (name, price).
2. Cria `ProductService` com `FileProductRepository` e `SimpleProductValidator`.
3. `ProductService::create($input)`:
   - Chama `validator->validate($input)`.
   - Se inválido, retorna false (apresentação decide mensagem/HTTP).
   - Se válido, monta produto com ID e price normalizado, chama `repo->save($product)`.
4. `public/products.php` cria `ProductService` e chama `list()` → `repo->findAll()` para renderizar tabela HTML.

## Casos de Teste (Manuais)

Documente passos reproduzíveis com entrada e resultado esperado:

### Caso 1 – Cadastro válido
- Entrada: name="Teclado", price=120.50
- Resultado esperado: HTTP 201, produto criado e aparece na listagem.

### Caso 2 – Nome curto
- Entrada: name="T", price=50
- Resultado esperado: HTTP 422, mensagem de validação (nome < 2 caracteres).

### Caso 3 – Preço negativo
- Entrada: name="Mouse", price=-10
- Resultado esperado: HTTP 422, rejeitado.

### Caso 4 – Lista vazia
- Arquivo vazio
- Resultado esperado: página exibe "Nenhum produto cadastrado".

### Caso 5 – Múltiplos cadastros
- Cadastrar 3 produtos
- Resultado esperado: listagem com ordem correta e IDs sequenciais.

## Critérios de Aceite

- Projeto roda em `http://localhost/products-srp-demo/public/`.
- `ProductService` não contém echo/I/O; apenas orquestra.
- `FileProductRepository` é o único que lê/escreve no arquivo.
- `SimpleProductValidator` apenas valida.
- Código segue PSR-12 e organização em camadas.