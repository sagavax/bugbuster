<?php

    include "../includes/dbconnect.php";
    include "../includes/functions.php";

    $note_id = $_POST['note_id'];
    $app_name = $_POST['app_name'];
  
    $chage_app = "UPDATE apps SET is_active_dev=0 WHERE app_id=$app_id";
    $result = mysqli_query($link, $chage_app) or die("MySQLi ERROR: ".mysqli_error($link));

    //add to app logu
    $diary_text="Vvyvo aplikacie s id: <strong>$id_id </strong> bol ukonceny / preruseny";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die(mysql_error());