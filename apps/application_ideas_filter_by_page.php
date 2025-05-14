<?php

    session_start();
    include("../includes/dbconnect.php");
    include("../includes/functions.php");

    $page = $_POST['page'];
    $app_name = mysqli_real_escape_string($link, $_POST['app_name']);

     $itemsPerPage = 10;
     $current_page = isset($_POST['page']) ? $_POST['page'] : 1;
    $offset = ($current_page - 1) * $itemsPerPage;        

     $get_ideas = "SELECT * FROM ideas WHERE idea_application='$app_name' ORDER BY idea_id DESC LIMIT $offset, $itemsPerPage";
    $result_ideas = mysqli_query($link, $get_ideas) or die(mysqli_error($link));
        while ($row_ideas = mysqli_fetch_array($result_ideas)) {
            $idea_id = $row_ideas['idea_id'];
            $idea_title = $row_ideas['idea_title'];
            $idea_text = $row_ideas['idea_text'];
            $idea_status = $row_ideas['idea_status'];
            $idea_priority = $row_ideas['idea_priority'];
            $idea_comments = $row_ideas['comments'];
            $idea_date = $row_ideas['added_date'];
            echo "<div class='idea' data-idea-id=$idea_id>";
                echo "<div class='idea_title'>$idea_title</div>";
                echo "<div class='idea_text'>$idea_text</div>";
                echo "<div class='idea_date'>$idea_date</div>";
            echo "</div>";
        }