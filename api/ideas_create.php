<?php

    include '../includes/dbconnect.php';
    include '../includes/functions.php';


    $idea_title = mysqli_real_escape_string($link,$_POST['idea_title']) ?? '';
    $idea_description = mysqli_real_escape_string($link,$_POST['idea_text']) ?? '';
    $idea_application = mysqli_real_escape_string($link,$_POST['idea_application']) ?? '';
    $idea_priority = mysqli_real_escape_string($link,$_POST['idea_priority']) ?? '';
    $idea_status = mysqli_real_escape_string($link,$_POST['idea_status']) ?? '';


    $create_idea_query = "INSERT INTO ideas (idea_title, idea_text, idea_application, idea_priority, idea_status, added_date VALUES ('$idea_title', '$idea_description', '$idea_application', '$idea_priority', '$idea_status', now())";
    $result = mysqli_query($link, $create_idea_query) or die(mysqli_error($link));

    if ($result) {
        http_response_code(201);
        echo json_encode(['success' => 'idea created successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error creating idea']);
    }