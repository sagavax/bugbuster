<?php
    include "includes/dbconnect.php";
    include "includes/functions.php";


    $bug_title = mysqli_real_escape_string($link,$_POST['bug_title']) ?? '';
    $bug_text = mysqli_real_escape_string($link,$_POST['bug_description']) ?? '';
   
    $bug_application = (isset($_POST['bug_appliacation']) && $_POST['bug_appliacation'] != 0) ? mysqli_real_escape_string($link,$_POST['bug_appliacation']) : 'bugbuster';
    $bug_priority = (isset($_POST['bug_priority']) && $_POST['bug_priority'] != 0) ? mysqli_real_escape_string($link,$_POST['bug_priority']) : 'low';
    $bug_status = (isset($_POST['bug_status']) && $_POST['bug_status'] != 0) ? mysqli_real_escape_string($link,$_POST['bug_status']) : 'new';
    
    //echo "bug_status : $bug_status";


    $is_fixed = 0;

    // Použitie pripraveného SQL dotazu na bezpečné vloženie
    $save_bug = "INSERT INTO bugs (bug_title, bug_text, bug_priority, bug_status, bug_application, is_fixed, added_date) 
                 VALUES ('$bug_title', '$bug_text', '$bug_priority', '$bug_status', '$bug_application', $is_fixed, now())";
    //echo $save_bug;
    mysqli_query($link, $save_bug) or die("MySQLi ERROR: ".mysqli_error($link));
    //$stmt = mysqli_prepare($link, $save_bug);
   /*  echo $stmt;
    mysqli_stmt_bind_param($stmt, "sssisi", $bug_title, $bug_text, $bug_priority, $bug_status, $bug_application, $is_fixed);
    mysqli_stmt_execute($stmt);
    var_dump($stmt); */
    
    // Získanie posledného ID bezpečne
    $max_id = mysqli_insert_id($link);

    // Logovanie do app_log
    $diary_text = "Bol zaznamenaný nový bug s ID $max_id pre aplikaciu $bug_application";
    $log_sql = "INSERT INTO app_log (diary_text, date_added) VALUES (?, now())";
    
    $log_stmt = mysqli_prepare($link, $log_sql);
    mysqli_stmt_bind_param($log_stmt, "s", $diary_text);
    mysqli_stmt_execute($log_stmt);