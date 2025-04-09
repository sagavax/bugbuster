<?php

    include "includes/dbconnect.php";
    include "includes/functions.php";

    $bug_id = $_POST['idea_id'];
    $comment_header = mysqli_real_escape_string($link,$_POST['comment_text']);
    

    $create_comment = "INSERT into ideas_comments (idea_id,idea_comm_header, comment_date) VALUES ($idea_id,'$comment_header',now())";
    $result = mysqli_query($link, $create_comment) or die("MySQLi ERROR: ".mysqli_error($link));

    //app log
    $diary_text="Bolo pridane novy kommentar k idea id <b>$idea_id</b>"; 
    $log_sql = "INSERT INTO app_log (diary_text, date_added) VALUES (?, now())";
    $log_stmt = mysqli_prepare($link, $log_sql);
    mysqli_stmt_bind_param($log_stmt, "s", $diary_text);
    mysqli_stmt_execute($log_stmt);
    mysqli_stmt_close($log_stmt);