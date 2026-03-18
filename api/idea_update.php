<?php

require_once '../includes/dbconnect.php';
require_once '../includes/functions.php';


$data = json_decode(file_get_contents('php://input'), true);

 
$idea_id = $data['idea_id'];
if(isset($data['idea_description'])) $idea_text = mysqli_real_escape_string($link, $data['idea_description']) ?? $data['idea_description'];


if(isset($data['idea_status'])) {
$idea_status = $data['idea_status'];
if($idea_status == 'implemented') {
    $is_implemented = 1;
} else {
    $is_implemented = 0;
    } 
}

if(isset($data['idea_priority'])) {
    $idea_priority = $data['idea_priority'];
}



 if(isset($data['idea_title'])){ // Aktualizace názvu bugu
        $idea_title = $data['idea_title'];
        $update_query = "UPDATE ideas SET idea_title='$idea_title' WHERE idea_id=$idea_id";
    } else if (isset($data['idea_description'])){ // Aktualizace popisu idea
        $idea_description = $data['idea_description'];
        $update_query = "UPDATE ideas SET idea_text='$idea_description' WHERE idea_id=$idea_id";
    } else if (isset($data['idea_status'])){ // Aktualizace statusu idea
        $idea_status = $data['idea_status'];
        if($idea_status == 'implemented') {
            $is_implemented = 1;
        } else {
            $is_implemented = 0;
        }
        $update_query = "UPDATE ideas SET is_implemented=$is_implemented WHERE idea_id=$idea_id";
    }

$result = mysqli_query($link, $update_query) or die(mysqli_error($link));

echo json_encode(['status' => 'success']);