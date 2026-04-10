<?php


    include "../includes/dbconnect.php";
    include "../includes/functions.php";

    $note_id = $_POST['note_id'];
    $tag_id = $_POST['tag_id'];
    $tag_name = mysqli_real_escape_string($link,$_POST['tag_name']);

    
    $add_tag = "INSERT INTO notes_tags (note_id, tag_id, tag_name) VALUES ($note_id, $tag_id, '$tag_name')";
    $result = mysqli_query($link, $add_tag) or die("MySQLi ERROR: ".mysqli_error($link));