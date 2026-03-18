<?php

    include "../includes/dbconnect.php";
    include "../includes/functions.php";

    $data = json_decode(file_get_contents('php://input'), true);

    // Dynamické nastavenie URL pro API podle prostředí (localhost vs produkce)
    $bug_id = $data['bug_id'];
    $bug_description = mysqli_real_escape_string($link,$data['bug_description']);

    if(isset($data['bug_title'])){ // Aktualizace názvu bugu
        $bug_title = $data['bug_title'];
        $update_query = "UPDATE bugs SET bug_title='$bug_title' WHERE bug_id=$bug_id";
    } else if (isset($data['bug_description'])){ // Aktualizace popisu bugu
        $bug_description = $data['bug_description'];
        $update_query = "UPDATE bugs SET bug_text='$bug_description' WHERE bug_id=$bug_id";
    } else if (isset($data['bug_status'])){ // Aktualizace statusu bugu
        $bug_status = $data['bug_status'];
        if($bug_status == 'fixed') {
            $is_fixed = 1;
        } else {
            $is_fixed = 0;
        }
        $update_status = "UPDATE bugs SET is_fixed=$is_fixed WHERE bug_id=$bug_id";
    }

    $result = mysqli_query($link, $update_query) or die(mysqli_error($link));      
    echo json_encode(['status' => 'success']);