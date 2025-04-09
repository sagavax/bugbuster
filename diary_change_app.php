<?php

    include "includes/dbconnect.php";
    include "includes/functions.php";


    $record_id = $_POST['record_id'];
    $project_id = $_POST['project_id'];
  
    $chage_app = "UPDATE diary SET project_id=$project_id WHERE id=$record_id";
    $result = mysqli_query($link, $chage_app) or die("MySQLi ERROR: ".mysqli_error($link));

    //add to app logu
    $diary_text="Bola zmenene aplikacia re zaznam id: <strong>$record_id/strong>";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die(mysql_error());