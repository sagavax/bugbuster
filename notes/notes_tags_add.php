<?php


    include "../includes/dbconnect.php";
    include "../includes/functions.php";

    $note_id = $_POST['note_id'];
    $tag_id = $_POST['tag_id'];

    
    $add_tag = "INSERT INTO note_tags (note_id, tag_id) VALUES ($note_id, $tag_id)";
    $result = mysqli_query($link, $add_tag) or die("MySQLi ERROR: ".mysqli_error($link));