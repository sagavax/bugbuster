<?php

include "includes/dbconnect.php";
include "includes/functions.php";


$get_notes = "SELECT * from notes ORDER BY created_date DESC";

$result = mysqli_query($link, $get_notes) or die("MySQLi ERROR: ".mysqli_error($link));
while ($row = mysqli_fetch_array($result)) {
    $note_id = $row['note_id'];
    $note_title = $row['note_title'];
    $note_text = $row['note_text'];
    $note_date = $row['created_date'];

    echo "<div class='note' note-id=$note_id>";
      echo "<div class='note_title'>$note_title</div>";
      echo "<div class='note_text'>$note_text</div>";
      echo "<div class='note_action'>";
        echo "<button class='button small_button' title='Delete Note'><i class='fa fa-times'></i></button>";
      echo "</div>"; // note_action
    echo "</div>";// note
}
