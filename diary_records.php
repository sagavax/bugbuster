<?php

    include "includes/dbconnect.php";
    include "includes/functions.php";

    $get_diary = "SELECT * from diary ORDER BY id DESC";

    $result = mysqli_query($link, $get_diary) or die("MySQLi ERROR: ".mysqli_error($link)); 

    while ($row = mysqli_fetch_array($result)) {
        $diary_date = $row['created_date'];
        $diary_text = $row['diary_text'];
        $app_id = $row['project_id'];
        $diary_app = GetAppName($app_id);

        echo "<div class='diary_record' data-id='" . $row['id'] . "'>
                <div class='diary_date'><span class='date_time'>$diary_date</span></div>
                <div class='diary_text'>$diary_text</div>
                <div class='diary_app'><span class='app_name'>$diary_app<span></div>
                <div class='diary_action'><button class='button button_small' name='delete'><i class='fa fa-times'></i></button></div>
              </div>";
    }

    ?>