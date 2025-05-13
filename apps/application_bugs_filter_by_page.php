<?php

    session_start();
    include("../includes/dbconnect.php");
    include("../includes/functions.php");

    $page = $_POST['page'];
    $app_name = mysqli_real_escape_string($link, $_POST['app_name']);

    $itemsPerPage = 10;
    $current_page = isset($_POST['page']) ? $_POST['page'] : 1;
    $offset = ($current_page - 1) * $itemsPerPage;   

    $get_bugs = "SELECT * FROM bugs WHERE bug_application='$app_name' ORDER BY bug_id DESC LIMIT $offset, $itemsPerPage";
    $result_bugs = mysqli_query($link, $get_bugs) or die(mysqli_error($link));
        while ($row_bugs = mysqli_fetch_array($result_bugs)) {
                $bug_id = $row_bugs['bug_id'];
                $bug_title = $row_bugs['bug_title'];
                $bug_text = $row_bugs['bug_text'];
                $bug_status = $row_bugs['bug_status'];
                $bug_priority = $row_bugs['bug_priority'];
                $bug_comments = $row_bugs['comments'];
                $bug_date = $row_bugs['added_date'];
                echo "<div class='bug' data-bug-id=$bug_id>";
                if($bug_title !=""){
                    echo "<div class='bug_title'>$bug_title</div>";
                }   
                echo "<div class='bug_text'>$bug_text</div>";
                echo "<div class='bug_date'>$bug_date</div>";
            echo "</div>";
        }