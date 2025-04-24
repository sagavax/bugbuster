<?php
    include "../includes/dbconnect.php";
    include "../includes/functions.php";

    $move_bug_to_ideas = "INSERT into ideas (bug_id) VALUES ($bug_id)";
    $result = mysqli_query($link, $move_bug_to_ideas) or die("MySQLi ERROR: ".mysqli_error($link));


    //add to app logu
    $diary_text="Bola pridana idea s id: <strong>$bug_id</strong>";

    ?>