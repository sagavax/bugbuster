<?php

include "../includes/dbconnect.php";
include "../includes/functions.php";

$bug_id = $_POST['bug_id'];
$bug_status = $_POST['bug_status'];


$update_status = "UPDATE bugs SET bug_status='$bug_status' WHERE bug_id=$bug_id";
$result = mysqli_query($link, $update_status) or die(mysqli_error($link));


// Add diary entry

$diary_text="Bug s id $bug_id status sa zmenil na $bug_status";
$create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
$result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));

//add to timeline
$diary_text="Status bugu sa zmenil na $bug_status";
$create_record="INSERT INTO bugs_timeline (object_id, object_type, parent_object_id, timeline_text, created_date) VALUES ($bug_id, 'bug', $bug_id,'$diary_text', now())";
$result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));