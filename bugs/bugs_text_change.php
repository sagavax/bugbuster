<?php

    include("../includes/dbconnect.php");
    include("../includes/functions.php");

    
    $bug_id = $_POST['bug_id'];
    $bug_text = mysqli_real_escape_string($link,$_POST['bug_text']);

    //change title
    $sql = "UPDATE bugs SET bug_text = '$bug_text' WHERE bug_id = $bug_id";
    $result = mysqli_query($link, $sql) or die(mysql_error($link));


    ///add to logu
    $diary_text="Bol zmeneny text bugu s id: <strong>$bug_id</strong>";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die(mysql_error($link));


    //add to timeline
    $diary_text="Bol zmeneny text bugu";
    $create_record="INSERT INTO bugs_timeline (object_id, object_type, parent_object_id, timeline_text, created_date) VALUES ($bug_id, 'bug', $bug_id,'$diary_text', now())";
    $result = mysqli_query($link, $sql) or die(mysql_error($link));