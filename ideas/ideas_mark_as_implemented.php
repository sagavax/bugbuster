<?php
    include "../includes/dbconnect.php";
    include "../includes/functions.php";


    $idea_id = $_POST['idea_id'];


    $mark_as_implemented = "UPDATE ideas SET is_implemented=1, idea_status='implemented' WHERE idea_id=$idea_id";
    $result = mysqli_query($link, $mark_as_implemented) or die("MySQLi ERROR: ".mysqli_error($link));

    //add to app logu
    $diary_text="Idea s: <strong>$idea_id/strong> bola implementovana";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die(mysql_error());

    //set implemented date
    $implemented_date = "UPDATE ideas SET implemented_date=now() WHERE idea_id=$idea_id";
    $result = mysqli_query($link, $implemented_date) or die("MySQLi ERROR: ".mysqli_error($link));

    //add to timeline
    $diary_text="Idea bola implementovana";
    $create_record="INSERT INTO ideas_timeline (object_id, object_type, parent_object_id, timeline_text, created_date) VALUES ($idea_id, 'idea', $idea_id,'$diary_text', now())";
    $result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));