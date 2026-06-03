# E-commerce

O desafio é criar 4 endpoints de uma API:

## 1 - Criar produto

Esse endpoint `POST` deve receber como payload um JSON contendo quaisquer campos,
porém um campo nome deve ser obrigatório. Esses campos precisam ser salvos no
`MongoDB`. Além disso, o nome e ID devem ser indexados no `ElasticSearch` para buscas
textuais além de serem salvos como um novo nó no `Neo4J` para que compras possam ser
salvas futuramente.

## 2 - Buscar produto

Esse endpoint `GET` deve receber um parâmetro busca na URL e realizar uma busca
textual no `ElasticSearch` com esse termo, retornando o nome e o ID do produto

## 3 - Comprar produto

Esse endpoint `POST` deve receber como payload um JSON contendo o ID do produto
e o nome de um usuário que está realizando a compra. Essa compra deve ser inserida
como um relacionamento no `Neo4J`. Além disso, uma mensagem deve ser enviada para o
`RabbitMQ` informando a compra do produto. Não precisa criar um consumidor para essas
mensagens.

## 4 - Recomendar produtos

Esse endpoint `GET` deve receber um parâmetro usuario na URL e exibir os produtos
recomendados para ele.
