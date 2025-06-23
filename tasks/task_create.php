<?php       

 include("../includes/dbconnect.php");

 $task_title = mysqli_real_escape_string($link,$_POST['task_title']);
 $task_description = mysqli_real_escape_string($link,$_POST['task_description']);
 $task_application = mysqli_real_escape_string($link,$_POST['task_application']);
 $task_priority = mysqli_real_escape_string($link,$_POST['task_priority']);
 $task_status = mysqli_real_escape_string($link,$_POST['task_status']);

 $create_task = "INSERT INTO tasks (task_title,task_description,task_application,task_priority,task_status,created_date) VALUES('$task_title','$task_description','$task_application','$task_priority','$task_status',NOW())";
 $create_task_result = mysqli_query($link,$create_task) or die(mysqli_error($link));

 if ($create_task_result) {
    header("Location: index.php");
 }



