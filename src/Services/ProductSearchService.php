<?php

namespace Sqmatheus\Ecommerce\Services;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Sqmatheus\Ecommerce\DTOs\CreateProductDto;

class ProductSearchService {

    private const string INDEX = 'products';
    private const string TYPE = 'products';

    private Client $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts(['http://elasticsearch:9200'])
            ->build();

        if (! $this->client->indices()->exists(['index' => self::INDEX])) {
            $this->client->indices()->create([
                'index' => self::INDEX
            ]);
        }
    }

    public function createProduct(string $id, CreateProductDto $dto): void {
        $this->client->index([
            'index' => self::INDEX,
            'type' => self::TYPE,
            'body' => [
                'id' => $id,
                'name' => $dto->name
            ]
        ]);
    }
    
}