<?php

    include("../includes/dbconnect.php");
    include("../includes/functions.php");


    $bug_id = $_POST['bug_id'];
    $bug_title = mysqli_real_escape_string($link,$_POST['bug_title']);


    $sql = "UPDATE bugs SET bug_title = '$bug_title' WHERE bug_id = '$bug_id'";
    $result = mysqli_query($link, $sql) or die(mysql_error($link));


    ///add to logu
    $diary_text="Bol zmeneny nadpis bugu s id: <strong>$bug_id</strong>";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die(mysql_error($link));


    //add to timeline
    $diary_text="Bol zmeneny nadpis bugu s id: <strong>$bug_id</strong>";
    $create_record="INSERT INTO bugs_timeline (object_id, object_type, parent_object_id, timeline_text, created_date) VALUES ($bug_id, 'bug', $bug_id,'$diary_text', now())";
    $result = mysqli_query($link, $sql) or die(mysql_error($link));