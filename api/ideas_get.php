<?php

    include('../includes/dbconnect.php');
    include('../includes/functions.php');

   $app_name = mysqli_real_escape_string($link,$_GET['app_name'])??'';
    
    //$get_ideas = "SELECT * FROM ideas WHERE idea_application='$app_name' ORDER BY added_date DESC";
    $get_ideas = "SELECT a.*, (SELECT COUNT(*) FROM ideas_comments  WHERE idea_id = a.idea_id) AS count_comments FROM ideas a WHERE idea_application = '$app_name' ORDER BY added_date DESC";
    //echo $get_ideas;
    $result_ideas = mysqli_query($link, $get_ideas);
    $ideas = array();
    while ($row = mysqli_fetch_array($result_ideas)) {
        $ideas[] = $row;
    }
    echo json_encode($ideas);
?>