<?php

    include('../includes/dbconnect.php');
    include('../includes/functions.php');


    $app_name = mysqli_real_escape_string($link,$_GET['app_name'])??'';

    //$get_bugs = "SELECT * FROM bugs WHERE bug_application='$app_name' ORDER BY added_date DESC";
    $get_bugs = "SELECT a.*, (SELECT COUNT(*) FROM bugs_comments  WHERE bug_id = a.bug_id) AS count_comments FROM bugs a WHERE bug_application = '$app_name' ORDER BY added_date DESC";
    $result_bugs = mysqli_query($link, $get_bugs) or die(mysqli_error($link));
    $bugs = array();
    while ($row = mysqli_fetch_array($result_bugs)) {
        $bugs[] = $row;
    }
    echo json_encode($bugs);
    ?>
