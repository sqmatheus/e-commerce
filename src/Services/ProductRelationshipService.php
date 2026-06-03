<?php

namespace Sqmatheus\Ecommerce\Services;

use Laudis\Neo4j\ClientBuilder;
use Laudis\Neo4j\Contracts\ClientInterface;
use Laudis\Neo4j\Types\CypherMap;
use Sqmatheus\Ecommerce\DTOs\BuyProductDto;
use Sqmatheus\Ecommerce\DTOs\CreateProductDto;
use Sqmatheus\Ecommerce\DTOs\RecommendedProductDto;

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

    public function recommendationFor(string $userName) {
        $results = $this->client->run('MATCH (u:User {name: $userName})-[:BOUGHT]->(p:Product)
        WITH collect(p.id) AS ps, u

        MATCH (o:User)-[:BOUGHT]->(s:Product)
        WHERE o <> u AND NOT s.id IN ps

        RETURN DISTINCT s', ['userName' => $userName]);

        $data = [];
        foreach ($results as $item) {
            /** @var CypherMap $item */
            $product = $item->get('s');

            $data[] = new RecommendedProductDto(
                id: $product->getProperty('id'),
                name: $product->getProperty('name')
            );
        }

        return $data;
    }
}