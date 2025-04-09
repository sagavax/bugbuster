<?php

include("includes/dbconnect.php");
include("includes/functions.php");

$record_id = $_POST['record_id'];

$sql = "DELETE FROM diary WHERE id=$record_id";
$result = mysqli_query($link, $sql) or die(mysql_error());

//add to app logu
$diary_text="Bol odstraneny zaznam id: <strong>$record_id/strong>";
$sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
$result = mysqli_query($link, $sql) or die(mysql_error());

?>