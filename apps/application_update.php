<?php
    
include "../includes/dbconnect.php";
include "../includes/functions.php";


$app_name = mysqli_real_escape_string($link,$_POST['app_name']);
$app_short_name = mysqli_real_escape_string($link,$_POST['app_short_name']);
$app_descr = mysqli_real_escape_string($link,$_POST['app_descr']);
$app_id = $_POST['app_id'];


$update_app = "UPDATE apps SET app_name='$app_name',app_short_name='$app_short_name',app_descr='$app_descr' WHERE app_id=$app_id";
$result = mysqli_query($link, $update_app) or die("MySQLi ERROR: ".mysqli_error($link));

echo "<script>alert('Zmenene')</script>";
echo "<script>window.location.href='index.php'</script>";