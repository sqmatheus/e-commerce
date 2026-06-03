<?php

namespace Sqmatheus\Ecommerce\Services;

use Laudis\Neo4j\ClientBuilder;
use Laudis\Neo4j\Contracts\ClientInterface;
use Sqmatheus\Ecommerce\DTOs\BuyProductDto;
use Sqmatheus\Ecommerce\DTOs\CreateProductDto;

class ProductRelationshipService {

    private ClientInterface $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->withDriver('bolt', 'bolt://neo4j:12345678@neo4j')
            ->build();
    }

    public function createProductNode(string $id, CreateProductDto $dto): void {
        $this->client->run('CREATE (p:Product {id: $id, name: $name})', ['id' => $id, 'name' => $dto->name]);
    }

    public function createRelationProductUser(BuyProductDto $dto) {
        $this->client->run('MATCH (u:User {name: $userName}), (p:Product {id: $idProduct})
        CREATE (u)-[:BOUGHT]->(p)', [
            'idProduct' => $dto->idProduct,
            'userName' => $dto->userName,
        ]);
    }
}