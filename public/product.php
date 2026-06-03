<?php

use Sqmatheus\Ecommerce\DTOs\CreateProductDto;
use Sqmatheus\Ecommerce\Repositories\ProductRepository;
use Sqmatheus\Ecommerce\Services\ProductRelationshipService;
use Sqmatheus\Ecommerce\Services\ProductSearchService;

require_once __DIR__ . '/../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['error' => 'Method Not Allowed'], 405);
}

$body = file_get_contents('php://input');
if ($body === false) {
    json_response(['error' => 'Failed to read request body'], 500);
}

$data = json_decode($body, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    json_response(['error' => 'Invalid JSON'], 400);
}

if (!isset($data['name'])) {
    json_response(['error' => 'The product name is required'], 422);
}

if (mb_strlen($data['name']) < 8) {
    json_response(['error' => 'The product name must be at least 8 characters'], 422);
}

$dto = new CreateProductDto(
    $data['name'],
    $data['description'] ?? null,
    isset($data['price'])
        ? (float) $data['price']
        : null,
);

$productRepository = new ProductRepository();
$productSearchService = new ProductSearchService();
$productRelationshipService = new ProductRelationshipService();

$result = $productRepository->create($dto);

$idProduct = (string) $result;

$productSearchService->createProduct($idProduct, $dto);
$productRelationshipService->createProductNode($idProduct, $dto);

json_response(['data' => $result], 201);