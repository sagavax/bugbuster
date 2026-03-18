<?php

    include "../includes/dbconnect.php";
    include "../includes/functions.php";


    $bug_id = $_GET['bug_id'] ?? '';

    $get_bug = "SELECT * FROM bugs WHERE bug_id=$bug_id";
    $result_bug = mysqli_query($link, $get_bug) or die("MySQLi ERROR: ".mysqli_error($link));
    $bug = array();
    while ($row = mysqli_fetch_array($result_bug)) {
        $bug[] = $row;
    }
    echo json_encode($bug);
    ?>