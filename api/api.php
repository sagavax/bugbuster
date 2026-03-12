<?php
header('Content-Type: application/json');

$endpoint = $_GET['endpoint'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];

$allowed_endpoints = ['bugs', 'ideas', 'idea', 'bug','idea_comments', 'bug_comments']; // sem pridávaj nové endpointy

$method_map = [
    'GET'    => 'get',
    'POST'   => 'create',
    'DELETE' => 'delete',
    'PUT'    => 'update',
    'PATCH'  => 'update',
];

if (empty($endpoint)) {
    http_response_code(400);
    echo json_encode(['error' => 'Endpoint is required']);
    exit;
}


if (!in_array($endpoint, $allowed_endpoints)) {
    http_response_code(404);
    echo json_encode(['error' => 'Endpoint not found']);
    exit;
}

if (!isset($method_map[$method])) {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$file = "{$endpoint}_{$method_map[$method]}.php";

if (!file_exists($file)) {
    http_response_code(501);
    echo json_encode(['error' => 'Not implemented']);
    exit;
}

require $file;