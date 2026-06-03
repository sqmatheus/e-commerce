<?php

namespace Sqmatheus\Ecommerce\Repositories;

use MongoDB\BSON\ObjectId;
use MongoDB\Client;
use MongoDB\Collection;
use Sqmatheus\Ecommerce\DTOs\CreateProductDto;
use Sqmatheus\Ecommerce\DTOs\ProductDto;
use Throwable;

class ProductRepository {

    private Collection $collection;

    public function __construct()
    {
        $client = new Client('mongodb://mongodb', [
            'username' => 'user',
            'password' => 'password'
        ]);

        $database = $client->selectDatabase('ecommerce');

        $this->collection = $database->getCollection('products');
    }

    public function create(CreateProductDto $dto): ObjectId {
        $result = $this->collection->insertOne([
            'name' => $dto->name,
            'description' => $dto->description,
            'price' => $dto->price
        ]);

        return $result->getInsertedId();
    }

    public function find(string $id): ?ProductDto {
        try {
            $result = $this->collection->findOne([
                '_id' => new ObjectId($id),
            ]);

            if ($result === null) {
                return null;
            }

            return new ProductDto(
                $result['name'],
                $result['description'],
                $result['price']
            );
        } catch (Throwable) {
            return null;
        }
    }

}