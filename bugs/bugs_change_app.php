<?php

    include "../includes/dbconnect.php";
    include "../includes/functions.php";


    $bug_id = $_POST['bug_id'];
    $app_name = $_POST['app_name'];
  
    $chage_app = "UPDATE bugs SET bug_application='$app_name' WHERE bug_id=$bug_id";
    $result = mysqli_query($link, $chage_app) or die("MySQLi ERROR: ".mysqli_error($link));

    //add to app logu
    $diary_text="Bola zmenena aplikacia pre bug id: <strong>$bug_id                                                                                                                                                                                                                                                                                                                                                                                                                     /strong>";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die(mysql_error());

    //add to timeline
    $diary_text="Aplikacia bugu sa zmenila na $app_name";    
    $create_record="INSERT INTO bug_timeline (object_id, object_type, parent_object_id, timeline_text, created_date) VALUES ($bug_id, 'bug', $bug_id,'$diary_text', now())";
    $result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));