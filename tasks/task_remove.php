<?php

 include("../includes/dbconnect.php");
 $task_id = $_POST['task_id'];
 $remove_task = "DELETE FROM tasks WHERE task_id = $task_id";
 $remove_task_result = mysqli_query($link, $remove_task) or die(mysqli_error($link));
 if ($remove_task_result) {
    header("Location: index.php");
 }