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

    $bug_comment = mysqli_real_escape_string($link, $data['bug_comment']);
    $bug_comment_header = mysqli_real_escape_string($link, $data['bug_comment_header']);

    $save_comment = "INSERT into bugs_comments (bug_id,bug_comm_header, bug_comment, comment_date) VALUES ($bug_id,'$bug_comment_header','$bug_comment',now())";
    $result=mysqli_query($link, $save_comment);

    if (!$result) {
        http_response_code(500);
        echo json_encode(['error' => mysqli_error($link)]);
        exit;
    }

    echo json_encode(['success' => true, 'comment_id' => mysqli_insert_id($link)]);