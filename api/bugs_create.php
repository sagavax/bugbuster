<?php

    include '../includes/dbconnect.php';
    include '../includes/functions.php';


    $bug_title = mysqli_real_escape_string($link,$_POST['bug_title']) ?? '';
    $bug_description = mysqli_real_escape_string($link,$_POST['bug_description']) ?? '';
    $bug_application = mysqli_real_escape_string($link,$_POST['bug_application']) ?? '';
    $bug_priority = mysqli_real_escape_string($link,$_POST['bug_priority']) ?? '';
    $bug_status = mysqli_real_escape_string($link,$_POST['bug_status']) ?? '';


    $create_bug_query = "INSERT INTO bugs (bug_title, bug_description, bug_application, bug_priority, bug_status, added_date VALUES ('$bug_title', '$bug_description', '$bug_application', '$bug_priority', '$bug_status', now())";
    $result = mysqli_query($link, $create_bug_query) or die(mysqli_error($link));