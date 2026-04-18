<?php

    include "../includes/dbconnect.php";
    include "../includes/functions.php";


    if(isset($_GET['note_id'])){
        $note_id = $_GET['note_id'];
    }

    $get_note_tags = "SELECT nt.note_id, t.tag_id, t.tag_name FROM note_tags nt JOIN tags t ON nt.tag_id = t.tag_id WHERE nt.note_id = $note_id";
    $result_note_tags = mysqli_query($link, $get_note_tags) or die("MySQLi ERROR: ".mysqli_error($link));
    while ($row = mysqli_fetch_array($result_note_tags)) {
        $note_tags[] = array(
            "note_id" => $row['note_id'],
            "tag_id" => $row['tag_id'],
            "tag_name" => $row['tag_name']
        );
    }

    echo json_encode($note_tags);