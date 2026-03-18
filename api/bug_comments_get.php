<?php

    include "../includes/dbconnect.php";
    include "../includes/functions.php";


    $bug_id = (int)($_GET['bug_id'])??0;

    $get_comments = "SELECT * FROM bugs_comments WHERE bug_id=$bug_id ORDER BY comment_date DESC";
    $result_comments = mysqli_query($link, $get_comments);
    $comments = array();
    while ($row = mysqli_fetch_assoc($result_comments)) {
        $comments[] = $row;
    }
    echo json_encode($comments);