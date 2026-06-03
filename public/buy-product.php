<?php

use Sqmatheus\Ecommerce\DTOs\BuyProductDto;
use Sqmatheus\Ecommerce\Repositories\ProductRepository;
use Sqmatheus\Ecommerce\Services\ProductRelationshipService;

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

if (!isset($data['id_product'])) {
    json_response(['error' => 'The product id is required'], 422);
}

if (!isset($data['username'])) {
    json_response(['error' => 'The username is required'], 422);
}

$dto = new BuyProductDto(
    $data['id_product'],
    $data['username'],
);

$productRepository = new ProductRepository();
$product = $productRepository->find($dto->idProduct);

if ($product === null) {
    json_response(['error' => 'Product not found'], 404);
}

$productRelationshipService = new ProductRelationshipService();
$productRelationshipService->createRelationProductUser($dto);

json_response([
    'message' => 'Purchase successful',
    'product' => $product
], 201);