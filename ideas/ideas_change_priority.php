<?php

include "../includes/dbconnect.php";
include "../includes/functions.php";

$idea_priority=$_POST['idea_priority'];
$idea_id = $_POST['idea_id'];

$update_prioty = "UPDATE ideas SET idea_priority='$idea_priority' WHERE idea_id=$idea_id";
$result = mysqli_query($link, $update_prioty);

//add to audit log
$diary_text="Idea s id $idea_id bola priorita zmenena na $idea_priority";
$create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
$result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));

//add to timeline
$diary_text="Priorita idea sa zmenila na $idea_priority";
$create_record="INSERT INTO ideas_timeline (object_id, object_type, timeline_text, created_date) VALUES ($idea_id, 'idea','$diary_text', now())";
$result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));