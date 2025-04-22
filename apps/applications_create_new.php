<?php

include "../includes/dbconnect.php";
include "../includes/functions.php";


$app_name = mysqli_real_escape_string($link,$_POST['app_name']);
$app_descr = mysqli_real_escape_string($link,$_POST['app_descr']);


$create_the_app = "INSERT INTO apps (app_name, app_descr, added_date) VALUES ('$app_name', '$app_descr',now())";
$result = mysqli_query($link, $create_the_app) or die(mysqli_error($link));

//add to app logu
$diary_text="Aplikacia <strong>$app_name</strong> bola vytvorena";
$create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
$result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));