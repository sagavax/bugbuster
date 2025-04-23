<?php

include "../includes/dbconnect.php";
include "../includes/functions.php";    

$bug_id = $_POST['bug_id'];
$label = mysqli_real_escape_string($link, $_POST['label']); //$_POST['label'];


$update_label = "INSERT INTO bugs_labels (bug_id, bug_label,added_date) VALUES ($bug_id,'$label',now())";
$result = mysqli_query($link, $update_label) or die("MySQLi ERROR: ".mysqli_error($link));

//add to app logu
$diary_text="Bol pridany label $label pre bug id $bug_id";
$sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
$result = mysqli_query($link, $sql) or die(mysql_error());

//add to timeline
$diary_text="Bol pridalny label <strong>$label</strong> pre bug id $bug_id";
$create_record="INSERT INTO bugs_timeline (object_id, object_type, parent_object_id, timeline_text, created_date) VALUES ($bug_id, 'bug', $bug_id,'$diary_text', now())";
$result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));

//add label for github issue (bug)
?>