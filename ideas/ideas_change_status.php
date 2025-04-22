<?php

include "../includes/dbconnect.php";
include "../includes/functions.php";

$idea_id = $_POST['idea_id'];
$idea_status = $_POST['idea_status'];


$update_status = "UPDATE ideas SET idea_status='$idea_status' WHERE idea_id=$idea_id";
$result = mysqli_query($link, $update_status) or die(mysqli_error($link));


// Add diary entry

$diary_text="Status idea s id $idea_id sa zmenil na $idea_status";
$create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
$result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));

//add to timeline
$diary_text="Status idea sa zmenil na $idea_status";
$create_record="INSERT INTO ideas_timeline (object_id, object_type,timeline_text, created_date) VALUES ($idea_id, 0,'idea','$diary_text', now())";
$result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));