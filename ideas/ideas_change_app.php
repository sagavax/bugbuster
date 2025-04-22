<?php

    include "../includes/dbconnect.php";
    include "../includes/functions.php";


    $idea_id = $_POST['idea_id'];
    $app_name = $_POST['app_name'];
  
    $chage_app = "UPDATE ideas SET idea_application='$app_name' WHERE idea_id=$idea_id";
    $result = mysqli_query($link, $chage_app) or die("MySQLi ERROR: ".mysqli_error($link));

    //add to app logu
    $diary_text="Bola zmenena aplikacia pre idea id: <strong>$idea_id                                                                                                                                                                                                                                                                                                                                                                                                                     /strong>";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die(mysql_error());