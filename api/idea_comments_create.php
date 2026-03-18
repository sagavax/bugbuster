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

    $idea_comment = mysqli_real_escape_string($link, $data['idea_comment']);
    $idea_comment_header = mysqli_real_escape_string($link, $data['idea_comment_header']);

    $save_comment = "INSERT into ideas_comments (idea_id,idea_comm_header, idea_comment, comment_date) VALUES ($idea_id,'$idea_comment_header','$idea_comment',now())";
    $result=mysqli_query($link, $save_comment);

    if (!$result) {
        http_response_code(500);
        echo json_encode(['error' => mysqli_error($link)]);
        exit;
    }

    echo json_encode(['success' => true, 'comment_id' => mysqli_insert_id($link)]);