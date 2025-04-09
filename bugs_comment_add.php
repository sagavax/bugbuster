<?php

    include "includes/dbconnect.php";
    include "includes/functions.php";

    $bug_id = $_POST['bug_id'];
    $comment_text = mysqli_real_escape_string($link,$_POST['comment_text']);
    

    $create_comment = "INSERT into bugs_comments (bug_id,bug_comm_header,bug_comment,application, comment_date) VALUES ($bug_id,'','$comment_text','',now())";
    $result = mysqli_query($link, $create_comment) or die("MySQLi ERROR: ".mysqli_error($link));

    //update nr of comments
    $update_nr_comments = "UPDATE bugs SET nr_comments = nr_comments + 1 WHERE bug_id = $bug_id";
    $result = mysqli_query($link, $update_nr_comments) or die("MySQLi ERROR: ".mysqli_error($link));
    
    //app log
    $diary_text="Bol pridany novy kommentar k bugu id <b>$bug_id</b>"; 
    $log_sql = "INSERT INTO app_log (diary_text, date_added) VALUES (?, now())";
    $log_stmt = mysqli_prepare($link, $log_sql);
    mysqli_stmt_bind_param($log_stmt, "s", $diary_text);
    mysqli_stmt_execute($log_stmt);
    mysqli_stmt_close($log_stmt);