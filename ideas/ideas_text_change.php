<?php

    include("../includes/dbconnect.php");
    include("../includes/functions.php");

    
    $idea_id = $_POST['idea_id'];
    $idea_text = mysqli_real_escape_string($link,$_POST['idea_text']);

    //change title
    $sql = "UPDATE ideas SET idea_text = '$idea_text' WHERE idea_id = $idea_id";
    $result = mysqli_query($link, $sql) or die(mysql_error($link));


    ///add to logu
    $diary_text="Bol zmeneny text ideau s id: <strong>$idea_id</strong>";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die(mysql_error($link));


    //add to timeline
    $diary_text="Bol zmeneny text ideau";
    $create_record="INSERT INTO ideas_timeline (object_id, object_type, parent_object_id, timeline_text, created_date) VALUES ($idea_id, 'idea', $idea_id,'$diary_text', now())";
    $result = mysqli_query($link, $sql) or die(mysql_error($link));