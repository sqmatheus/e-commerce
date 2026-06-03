<?php

require_once __DIR__ . '/vendor/autoload.php';

if (!function_exists('json_response')) {
    function json_response(mixed $data, int $statusCode = 200): void {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit();
    }
}