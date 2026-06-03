# E-commerce

Solução de um desafio proposto no curso **Persistência poliglota com PHP:
Implementando buscas, mensageria, bancos de dados de grafos e colunares** da [Alura](https://www.alura.com.br/)

## Tecnologias utilizadas

- PHP
- Docker
- MongoDB
- ElasticSearch
- RabbitMQ
- Neo4J

## Como rodar o projeto

### Pré-requisitos

- Docker
- Docker Compose

### Subir o ambiente

Na raiz do projeto, execute:

```sh
docker compose up -d
```

Isso irá iniciar todos os serviços necessários e estará disponível em:

```
http://localhost:8080
```

### Parar o ambiente

Para parar todos os serviços:

```sh
docker compose down
```

## Rodar seeds

Para popular o banco com usuários iniciais:

```sh
docker compose exec php php seed-users.php
```

## Desafio

### 1 - Criar produto

Esse endpoint `POST` deve receber como payload um JSON contendo quaisquer campos,
porém um campo nome deve ser obrigatório. Esses campos precisam ser salvos no
`MongoDB`. Além disso, o nome e ID devem ser indexados no `ElasticSearch` para buscas
textuais além de serem salvos como um novo nó no `Neo4J` para que compras possam ser
salvas futuramente.

```
POST /product.php

{
    "name": "<name>",
    "description": "<description>",
    "price": <price>
}
```

### 2 - Buscar produto

Esse endpoint `GET` deve receber um parâmetro busca na URL e realizar uma busca
textual no `ElasticSearch` com esse termo, retornando o nome e o ID do produto

```
GET /search-products.php?q=<search>
```

### 3 - Comprar produto

Esse endpoint `POST` deve receber como payload um JSON contendo o ID do produto
e o nome de um usuário que está realizando a compra. Essa compra deve ser inserida
como um relacionamento no `Neo4J`. Além disso, uma mensagem deve ser enviada para o
`RabbitMQ` informando a compra do produto. Não precisa criar um consumidor para essas
mensagens.

```
POST /buy-product.php HTTP/1.1

{
    "id_product": "<id>",
    "username": "<user>"
}
```

### 4 - Recomendar produtos

Esse endpoint `GET` deve receber um parâmetro usuario na URL e exibir os produtos
recomendados para ele.

```
GET /recommended-products.php?user=<user>
```
