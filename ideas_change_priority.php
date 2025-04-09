<?php

include "includes/dbconnect.php";
include "includes/functions.php";

$idea_priority=$_POST['idea_priority'];
$idea_id = $_POST['idea_id'];

$update_prioty = "UPDATE ideas SET priority='$idea_priority' WHERE idea_id=$idea_id";
$result = mysqli_query($link, $update_prioty);

//add to audit log
$diary_text="Minecraft IS: Idea s id $idea_id bola priorita zmenena na $idea_priority";
$create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
$result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));