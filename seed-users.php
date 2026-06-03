<?php

use Laudis\Neo4j\ClientBuilder;
use Laudis\Neo4j\Contracts\TransactionInterface;
use Laudis\Neo4j\Databags\Statement;

require_once __DIR__ . '/bootstrap.php';

$client = ClientBuilder::create()
    ->withDriver('bolt', 'bolt://neo4j:12345678@neo4j')
    ->build();

// Seed users
$client->writeTransaction(static function (TransactionInterface $transaction) {
    $transaction->runStatements(array_map(fn (string $username) => Statement::create('CREATE (u:User {name: $name})', ['name' => $username]), [
        'matheus', 'tailor', 'jonh', 'patrick', 'bob'
    ]));
});

echo "Created users" . PHP_EOL;

// Create relations
$client->writeTransaction(static function (TransactionInterface $transaction) {
    $statements = [];

    foreach ([
        'matheus' => 'tailor',
        'tailor' => 'jonh',
        'jonh' => 'patrick',
        'patrick' => 'bob',
        'bob' => 'matheus'
    ] as $from => $to) {
        $statements[] = Statement::create('MATCH (f:User {name: $from}), (t:User {name: $to})
        CREATE (f)-[:FRIEND]->(t)', ['from' => $from, 'to' => $to]);
    }

    $transaction->runStatements($statements);
});

echo "Created relationships" . PHP_EOL;
echo "Finished" . PHP_EOL;