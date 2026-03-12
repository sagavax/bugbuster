<?php

include "../includes/dbconnect.php";
include "../includes/functions.php";

$data = json_decode(file_get_contents('php://input'), true);

$bug_id = (int)($data['bug_id'] ?? 0);

if ($bug_id === 0) {
    http_response_code(400);
    echo json_encode(['error' => 'bug_id is required']);
    exit;
}

if (isset($data['bug_priority'])) {
    $bug_priority = mysqli_real_escape_string($link, $data['bug_priority']);
    $update_bug = "UPDATE bugs SET bug_priority='$bug_priority' WHERE bug_id=$bug_id AND bug_application='minecraft'";
} elseif (isset($data['bug_status'])) {
    $bug_status = mysqli_real_escape_string($link, $data['bug_status']);
    $update_bug = "UPDATE bugs SET bug_status='$bug_status' WHERE bug_id=$bug_id AND bug_application='minecraft'";
} else {
    http_response_code(400);
    echo json_encode(['error' => 'No valid field to update']);
    exit;
}

$result = mysqli_query($link, $update_bug);

if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => mysqli_error($link)]);
    exit;
}

echo json_encode(['success' => true, 'affected_rows' => mysqli_affected_rows($link)]);
