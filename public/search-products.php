<?php

use Sqmatheus\Ecommerce\Services\ProductSearchService;

require_once __DIR__ . '/../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    json_response(['error' => 'Method Not Allowed'], 405);
}

$searchTerm = filter_input(INPUT_GET, 'q', FILTER_FLAG_EMPTY_STRING_NULL);
if (empty($searchTerm)) {
    json_response(['error' => 'Invalid search query param'], 422);
}

$productSearchService = new ProductSearchService();
json_response(['data' => $productSearchService->search($searchTerm)]);
