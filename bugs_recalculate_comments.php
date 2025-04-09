<?php
    include "includes/dbconnect.php";
    include "includes/functions.php";


    $bug_id = $_POST['bug_id'];

    //get actual number of copments
    $get_comments = "SELECT nr_comments from bugs WHERE bug_id=$bug_id";
    $result = mysqli_query($link, $get_comments) or die("MySQLi ERROR: ".mysqli_error($link));
    $row = mysqli_fetch_array($result);
    $comments = $row['nr_comments'];
    echo $comments;