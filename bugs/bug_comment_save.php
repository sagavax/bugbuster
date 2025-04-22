<?php

include "../includes/dbconnect.php";
include "../includes/functions.php";

$comment_header = mysqli_real_escape_string($link,$_POST['header']);
$comment = mysqli_real_escape_string($link, $_POST['comment']);
$bug_id = $_POST['bug_id'];

$save_comment = "INSERT into bugs_comments (bug_id,bug_comm_header, bug_comment, comment_date) VALUES ($bug_id,'$comment_header','$comment',now())";
//echo $save_comment;
 $result=mysqli_query($link, $save_comment) or die("MySQLi ERROR: ".mysqli_error($link));

//app log
$diary_text="Minecraft IS: Bolo pridane novy kommentar k bugu id <b>$bug_id</b>";
$sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
$result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

//add to timeline
$diary_text="Bol pridany novy kommentar";
$create_record="INSERT INTO bug_timeline (object_id, object_type, parent_object_id, timeline_text, created_date) VALUES ($bug_id, 0,'bug_comment','$diary_text', now())";
$result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));