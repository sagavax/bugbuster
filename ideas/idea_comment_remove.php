<?php

    include("../includes/dbconnect.php");


    $comm_id = $_POST['comm_id'];
    $idea_id = $_POST['idea_id'];

    $remove_idea_comment = "DELETE from ideas_comments WHERE comm_id =$comm_id";
    $result = mysqli_query($link, $remove_idea_comment) or die(mysql_error());


    $total_comments = "UPDATE ideas SET comments = comments - 1 WHERE idea_id = $idea_id";
    echo $total_comments;
    $result = mysqli_query($link, $total_comments) or die("MySQLi ERROR: ".mysqli_error($link));



    //add to app logu
    $diary_text="Idea komentar s id: <strong>$comm_id</strong> bol vymazany";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die(mysql_error());


    //add to timeline
    $diary_text="Idea komentar bol vymazany";
    $create_record="INSERT INTO ideas_timeline (object_id, object_type, parent_object_id, timeline_text, created_date) VALUES ($comm_id, 'bug', $idea_id,'$diary_text', now())";
    $result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));