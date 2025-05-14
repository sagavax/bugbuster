<?php

    session_start();
    include("../includes/dbconnect.php");
    include("../includes/functions.php");

    $page = $_POST['page'];
    $app_name = mysqli_real_escape_string($link, $_POST['app_name']);

     $itemsPerPage = 10;
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($current_page - 1) * $itemsPerPage;  
        
    //$app_name = strtolower(getAppName($app_id));

    //echo "$app_name";
    
    $get_diary = "SELECT * FROM diary WHERE project_id=$app_id ORDER BY id DESC LIMIT $offset, $itemsPerPage";
    $result_diary = mysqli_query($link, $get_diary) or die(mysqli_error($link));
        while ($row_diary = mysqli_fetch_array($result_diary)) {
            $diary_id = $row_diary['id'];
            $diary_text = $row_diary['diary_text'];
            $diary_date = $row_diary['created_date'];
            echo "<div class='diary' data-diary-id=$diary_id>";
                echo "<div class='diary_text'>$diary_text</div>";
                echo "<div class='diary_date'>$diary_date</div>";
            echo "</div>";
        }