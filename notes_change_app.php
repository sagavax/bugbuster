<?php

    include "includes/dbconnect.php";
    include "includes/functions.php";


    $note_id = $_POST['note_id'];
    $app_name = $_POST['app_name'];
  
    $chage_app = "UPDATE notes SET note_application='$app_name' WHERE note_id=$note_id";
    $result = mysqli_query($link, $chage_app) or die("MySQLi ERROR: ".mysqli_error($link));

    //add to app logu
    $diary_text="Bola zmenene aplikacia pre zaznam id: <strong>$note_id/strong>";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die(mysql_error());