<?php

    include("../includes/dbconnect.php");
    include("../includes/functions.php");

    $comment_id = $_POST['comment_id'];
    $bug_id = $_POST['bug_id'];

    $remove_comment = "DELETE from bugs_comments WHERE comm_id=$comment_id";
    $result = mysqli_query($link, $remove_comment) or die(mysql_error());

    $total_comments = "UPDATE bugs SET comments = comments - 1 WHERE bug_id = $bug_id";
    $result = mysqli_query($link, $total_comments) or die("MySQLi ERROR: ".mysqli_error($link));

    //add to app logu
    $diary_text="Bug komentar s id: <strong>$comment_id</strong> bol vymazany";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die(mysql_error());


    //add to timeline
    $diary_text="Bug komentar bol vymazany";
    $create_record="INSERT INTO bugs_timeline (object_id, object_type, parent_object_id, timeline_text, created_date) VALUES ($comment_id, 'bug', $bug_id,'$diary_text', now())";
    $result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));