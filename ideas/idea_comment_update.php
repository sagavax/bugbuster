<?php

include "../includes/dbconnect.php";
include "../includes/functions.php";
session_start();

    
    $idea_comment_id = $_POST['comment_id'];
    $idea_comment = mysqli_real_escape_string($link,$_POST['updated_text']);

    $update_comment = "UPDATE ideas_comments SET idea_comment = '$idea_comment' WHERE comm_id = $idea_comment_id";
    mysqli_query($link, $update_comment) or die(mysqli_error($link));