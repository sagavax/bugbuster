<?php

include "../includes/dbconnect.php";
include "../includes/functions.php";

$bug_priority=$_POST['bug_priority'];
$bug_id = $_POST['bug_id'];

$update_prioty = "UPDATE bugs SET bug_priority='$bug_priority' WHERE bug_id=$bug_id";
$result = mysqli_query($link, $update_prioty);

//add to audit log
$diary_text="Bug s id $bug_id bol zmeneny prioritita na $bug_priority";
$create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
$result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));


//add to timeline
$diary_text="Priorita bugu sa zmenila na $bug_priority";
$create_record="INSERT INTO bug_timeline (object_id, object_type, timeline_text, created_date) VALUES ($bug_id, 'bug','$diary_text', now())";
$result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));