<?php
    include "../includes/dbconnect.php";
    include "../includes/functions.php";

    $bug_id = $_POST['bug_id'];
    //does it make sense check after the name?
    $bug_title = GetBugTitle($bug_id);

    //check if this bug is already in ideas
    $check_if_in_ideas = "SELECT * FROM ideas WHERE idea_tile = $bug_tile";
    $result = mysqli_query($link, $check_if_in_ideas) or die("MySQLi ERROR: ".mysqli_error($link));
    $row = mysqli_fetch_array($result);
    if ($row['bug_id'] == $bug_id) {
        echo "This bug is already in ideas";
        exit();
    }

    $move_bug_to_ideas = "INSERT into ideas (bug_id) VALUES ($bug_id)";
    $result = mysqli_query($link, $move_bug_to_ideas) or die("MySQLi ERROR: ".mysqli_error($link));


    //add to app logu
    $diary_text="Bola pridana idea s id: <strong>$bug_id</strong>";

    ?>