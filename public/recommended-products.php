<?php

use Sqmatheus\Ecommerce\Services\ProductRelationshipService;

require_once __DIR__ . '/../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    json_response(['error' => 'Method Not Allowed'], 405);
}

$userName = filter_input(INPUT_GET, 'user', FILTER_FLAG_EMPTY_STRING_NULL);
if ($userName === null || empty($userName)) {
    json_response(['error' => 'Invalid user query param'], 422);
}

$productRelationshipService = new ProductRelationshipService();

json_response(['data' => $productRelationshipService->recommendationFor($userName)]);