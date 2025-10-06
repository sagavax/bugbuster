<?php
header('Content-Type: application/json');

$endpoint = $_GET['endpoint'] ?? '';

$method = $_SERVER['REQUEST_METHOD'];

//volanie endpointov
/* //api/api.php?endpoint=products alebo /api/api.php?endpoint=users */

switch ($endpoint) {
    case 'bugs':
        if ($method === 'GET') {
            // Tu spracuj získanie všetkých bugov
            require 'bugs_get.php';
        } elseif ($method === 'POST') {
            // Tu spracuj vytvorenie nového bugu
            require 'bugs_create.php';
        } else if ($method === 'DELETE') {
            // remove bug
           require 'bugs_delete.php';
        } elseif ($method === 'PUT' || $method === 'PATCH') {
           require 'bugs_update.php'; // napríklad
        }  
        else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['error' => 'Method not allowed']);
        }
        break;

    case 'ideas':
        if ($method === 'GET') {
            // Tu spracuj získanie všetkých bugov
            require 'ideas_get.php';
        } elseif ($method === 'POST') {
            // Tu spracuj vytvorenie nového bugu
            require 'ideas_create.php';
        } else if ($method === 'DELETE') {
            // remove bug
           require 'ideas_delete.php';
        } elseif ($method === 'PUT' || $method === 'PATCH') {
           require 'ideas_update.php'; // napríklad
        }  
        else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['error' => 'Method not allowed']);
        }
        break;
      

    // Pridaj ďalšie endpointy podľa potreby

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Endpoint not found']);
        break;
}