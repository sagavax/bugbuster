<?php

    include "../includes/dbconnect.php";
    include "../includes/functions.php";


    $get_latest_bug = "SELECT * from bugs ORDER BY bug_id DESC LIMIT 1";
    $result = mysqli_query($link, $get_latest_bug) or die("MySQLi ERROR: ".mysqli_error($link)); 
    $row = mysqli_fetch_array($result);
    $bug_id = $row['bug_id'];
    echo $bug_id;