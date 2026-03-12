<?php

include "../includes/dbconnect.php";
include "../includes/functions.php";

$data = json_decode(file_get_contents('php://input'), true);

$idea_id = (int)($data['idea_id'] ?? 0);

if ($idea_id === 0) {
    http_response_code(400);
    echo json_encode(['error' => 'idea_id is required']);
    exit;
}

if (isset($data['idea_priority'])) {
    $idea_priority = mysqli_real_escape_string($link, $data['idea_priority']);
    $update_bug = "UPDATE ideas SET idea_priority='$idea_priority' WHERE idea_id=$idea_id AND idea_application='minecraft'";
} elseif (isset($data['idea_status'])) {
    $idea_status = mysqli_real_escape_string($link, $data['idea_status']);
    $update_bug = "UPDATE ideas SET idea_status='$idea_status' WHERE idea_id=$idea_id AND idea_application='minecraft'";
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
