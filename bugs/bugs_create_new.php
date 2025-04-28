<?php
    include "../includes/dbconnect.php";
    include "../includes/functions.php";
 

    //var_dump($_POST);


    $bug_title = mysqli_real_escape_string($link,$_POST['bug_title']) ?? '';
    $bug_text = mysqli_real_escape_string($link,$_POST['bug_description']) ?? '';
   
    //$bug_application = (isset($_POST['bug_appliacation']) && $_POST['bug_appliacation'] != 0) ? mysqli_real_escape_string($link,$_POST['bug_appliacation']) : 'bugbuster';
    if(isset($_POST['bug_application']) && $_POST['bug_application'] != 0){
        $bug_application = mysqli_real_escape_string($link,$_POST['bug_application']);
        //echo "bug_application : $bug_application";
    } else {
        $bug_application = 'bugbuster';
    }

    $bug_priority = (isset($_POST['bug_priority']) && $_POST['bug_priority'] != 0) ? mysqli_real_escape_string($link,$_POST['bug_priority']) : 'low';
    $bug_status = (isset($_POST['bug_status']) && $_POST['bug_status'] != 0) ? mysqli_real_escape_string($link,$_POST['bug_status']) : 'new';
    
    //echo "bug_status : $bug_status";
    //echo "bug_priority : $bug_priority";
     

    $is_fixed = 0;

    // Použitie pripraveného SQL dotazu na bezpečné vloženie
    $save_bug = "INSERT INTO bugs (bug_title, bug_text, bug_priority, bug_status, bug_application, is_fixed, added_date) 
                 VALUES ('$bug_title', '$bug_text', '$bug_priority', '$bug_status', '$bug_application', $is_fixed, now())";
    //echo $save_bug;
    mysqli_query($link, $save_bug) or die("MySQLi ERROR: ".mysqli_error($link));
  
    //add to github
    $token = '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';
    $result = createGithubIssue($bug_title, $bug_text, $token);

    
    if ($result['success']) {
        //echo "<script>alert('Issue bola úspešne vytvorená!');</script>";
        $max_id = mysqli_insert_id($link);
        $guthub_link = $result['response']['html_url'];
        $upated_github_link = "UPDATE bugs SET bug_github_url = '$guthub_link' WHERE bug_id = $max_id";
        mysqli_query($link, $upated_github_link) or die("MySQLi ERROR: ".mysqli_error($link));
        //print_r($result['response']);
    } else {
        echo "Nastala chyba: " . $result['error'] . "\n";
    }




    // Získanie posledného ID bezpečne
    $max_id = mysqli_insert_id($link);

    $guthub_link = $result['response']['html_url'];
    $upated_github_link = "UPDATE bugs SET bug_github_url = '$guthub_link' WHERE bug_id = $max_id";
    mysqli_query($link, $upated_github_link) or die("MySQLi ERROR: ".mysqli_error($link));

    // Logovanie do app_log
    $diary_text = "Bol zaznamenaný nový bug s ID $max_id pre aplikaciu $bug_application";
    $log_sql = "INSERT INTO app_log (diary_text, date_added) VALUES (?, now())";
    
    $log_stmt = mysqli_prepare($link, $log_sql);
    mysqli_stmt_bind_param($log_stmt, "s", $diary_text);
    mysqli_stmt_execute($log_stmt);


    //add to timeline
    $diary_text="Bol zaznamenaný nový bug s ID $max_id";
    $create_record="INSERT INTO bugs_timeline (object_id, object_type, parent_object_id, timeline_text, created_date) VALUES ($max_id, 'bug', $max_id,'$diary_text', now())";
    echo $create_record;
    $result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));

    header("Location: index.php");