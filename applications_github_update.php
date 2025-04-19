<?php
include "includes/dbconnect.php";
include "includes/functions.php";

$github_repo = mysqli_real_escape_string($link,$_POST['github_repo']);
$app_id = $_POST['app_id'];

$update_github_repo = "UPDATE apps SET github_repo = '$github_repo' WHERE app_id = '$app_id'";
$result = mysqli_query($link, $update_github_repo) or die("MySQLi ERROR: ".mysqli_error($link));

//add to app logu
$diary_text="Bol zmenene / pridane github repo aplikacie s id: <strong>$app_id </strong>";
$sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
$result = mysqli_query($link, $sql) or die(mysql_error());