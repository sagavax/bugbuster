<?php

    include("../includes/dbconnect.php");


    $comm_id = $_POST['comm_id'];

    $remove_idea_comment = "DELETE from ideas_comments WHERE comm_id =$comm_id";
    $result = mysqli_query($link, $remove_idea_comment) or die(mysql_error());


    //add to app logu
    $diary_text="Idea komentar s id: <strong>$comm_id</strong> bol vymazany";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die(mysql_error());