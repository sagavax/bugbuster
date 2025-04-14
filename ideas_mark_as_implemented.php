<?php
    include "includes/dbconnect.php";
    include "includes/functions.php";


    $idea_id = $_POST['idea_id'];


    $mark_as_implemented = "UPDATE ideas SET is_implemented=1 WHERE idea_id=$idea_id";
    $result = mysqli_query($link, $mark_as_implemented) or die("MySQLi ERROR: ".mysqli_error($link));

    //add to app logu
    $diary_text="Idea s: <strong>$idea_id/strong> bola implementovana";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die(mysql_error());