<?php

    include "includes/dbconnect.php";
    include "includes/functions.php";

    $note_id = $_POST['note_id'];

    //remove note
    $remove_note = "DELETE FROM notes WHERE note_id='$note_id'";
    $result = mysqli_query($link, $remove_note) or die("MySQLi ERROR: ".mysqli_error($link));

    //add to app logu
    $diary_text="Bola vymazana poznamka s id: <strong>$note_id</strong>";
    $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
    $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

    echo "<script>alert('Bola vymazana poznamka s id: $note_id')";   