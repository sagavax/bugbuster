<?php
    include '../includes/dbconnect.php';
   
     $data = json_decode(file_get_contents('php://input'), true);
        
     //print_r($data);

    $bug_title = mysqli_real_escape_string($link,$data['bug_title']) ?? '';
    $bug_description = mysqli_real_escape_string($link,$data['bug_text']);
    $bug_application = mysqli_real_escape_string($link,$data['bug_application']);
    $bug_priority = mysqli_real_escape_string($link,$data['bug_priority']);
    $bug_status = mysqli_real_escape_string($link,$data['bug_status']);

    $create_bug_query = "INSERT INTO bugs (bug_title, bug_text, bug_application, bug_priority, bug_status, added_date) VALUES ('$bug_title', '$bug_description', '$bug_application', '$bug_priority', '$bug_status', now())";
    $result = mysqli_query($link, $create_bug_query) or die(mysqli_error($link));

    echo json_encode(['success' => true, 'message' => 'Bug created successfully']);