<?php

    include "../includes/dbconnect.php";
    include "../includes/functions.php";

     $idea_id = (int)($_GET['idea_id'] ?? 0);

    $get_comments = "SELECT COUNT(*) as count FROM ideas_comments WHERE idea_id=$idea_id";
    $result_comments = mysqli_query($link, $get_comments);
    $comments = array();
    while ($row = mysqli_fetch_assoc($result_comments)) {
        $comments[] = $row;
    }
    echo json_encode($comments);