<?php  

include "../includes/dbconnect.php";
include "../includes/functions.php";


if(isset($_POST['bug_id'])){ 
    $bug_id = $_POST['bug_id'];
}


//$remove_bug = "DELETE from bugs WHERE bug_id=$bug_id";
$remove_bug = "UPDATE bugs SET bug_status='deleted' WHERE bug_id=$bug_id";
$result = mysqli_query($link, $remove_bug) or die("MySQLi ERROR: ".mysqli_error($link));

$diary_text = mysqli_real_escape_string($link, "Bug s id $bug_id bol vymazany");
$create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
$result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));

//add to timeline
$diary_text=mysqli_real_escape_string($link,"Bug bol vymazany");
$create_record="INSERT INTO bugs_timeline (object_id, object_type, parent_object_id, timeline_text, created_date) VALUES ($bug_id, 'bug', $bug_id,'$diary_text', now())";
$result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));