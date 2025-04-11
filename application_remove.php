<?php

    include "includes/dbconnect.php";
    include "includes/functions.php";

    $app_id = $_POST['app_id']; 
    $app_name = $_POST['app_name'];

    //remove app
    $remove_app = "DELETE FROM applications WHERE app_id=$app_id";
    $result = mysqli_query($link, $remove_app) or die("MySQLi ERROR: ".mysqli_error($link));


    ///po vymazani aplikacie vymaz vsetky zaznamy
    

    //add to app logu    
    $diary_text="Aplikacia <strong>$app_name</strong> bola vymazana";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die(mysql_error());