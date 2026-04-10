<?php

    include "../includes/dbconnect.php";
    include "../includes/functions.php";

    $note_id = $_POST['note_id'];
    $tag_id = $_POST['tag_id'];

    $check_tag = "SELECT * FROM notes_tags WHERE note_id=$note_id AND tag_id=$tag_id";
    $result_check = mysqli_query($link, $check_tag) or die("MySQLi ERROR: ".mysqli_error($link));
    $count = mysqli_num_rows($result_check);

    if ($count > 0) {
        echo "1";
    } else {
        echo "0";
    }