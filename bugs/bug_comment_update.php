<?php

include "../includes/dbconnect.php";
include "../includes/functions.php";

    
    $bug_comment_id = $_POST['comment_id'];
    $bug_comment = mysqli_real_escape_string($link,$_POST['updated_text']);

    $update_comment = "UPDATE bugs_comments SET bug_comment = '$bug_comment' WHERE comm_id = $bug_comment_id";
    //echo $update_comment; 
    mysqli_query($link, $update_comment) or die(mysqli_error($link));