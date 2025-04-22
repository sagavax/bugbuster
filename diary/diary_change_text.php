<?php   
    include "../includes/dbconnect.php";
    include "../includes/functions.php";

    $new_text = mysqli_real_escape_string($link,$_POST['new_text']);
    $record_id = $_POST['record_id'];

    $update_text ="UPDATE diary SET diary_text='$new_text' WHERE id=$record_id";
    $result = mysqli_query($link, $update_text) or die("MySQLi ERROR: ".mysqli_error($link));
    
    //add to app logu
    $diary_text="Bol zmeneny text zaznamu id: <strong>$record_id/strong>";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die(mysql_error());
