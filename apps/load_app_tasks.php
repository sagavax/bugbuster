 <?php    

    include "../includes/dbconnect.php";
    include "../includes/functions.php";

    $app_id = $_POST['app_id'];


    $itemsPerPage = 10;
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($current_page - 1) * $itemsPerPage;  
            
    $app_name = strtolower(getAppName($app_id));

    //echo "$app_name";
    $get_tasks = "SELECT * from tasks WHERE task_application='$app_name' ORDER BY task_id DESC";
    $result_tasks = mysqli_query($link, $get_tasks) or die(mysqli_error($link));
    while ($row_tasks = mysqli_fetch_array($result_tasks)) {
        $task_id = $row_tasks['task_id'];
        $task_title = $row_tasks['task_title'];
        $task_description = $row_tasks['task_description'];
        $task_priority = $row_tasks['task_priority'];
        $task_status = $row_tasks['task_status'];
        $task_application = $row_tasks['task_application'];
        echo "<div class='task' data-task-id=$task_id>";
            echo "<h4>$task_title</h4>";
            echo "<div class-'task_description'>$task_description</div>";
            echo "<div class='task_footer'>";
                echo "<div class='task_application'>$task_application</div>";
                echo "<div class='task_priority'>$task_priority</div>"; 
                echo "<div class='task_status'>$task_status</div>";
                echo "<button class='button small_button' type='button' name='remove_task' data-task-id=$task_id><i class='fa fa-times'></i></button>";
                //echo "<button class='button small_button' type='button' name='edit_task' data-task-id=$task_id><i class='fa fa-edit'></i></button>";
                //echo "<button class='button small_button' type='button' name='show_comments' data-task-id=$task_id><i class='fa fa-comment'></i></button>";
                echo "<button class='button small_button' type='button' name='mark_complete' data-task-id=$task_id><i class='fa fa-check'></i></button>";                                     
            echo "</div>";// task footer
        echo "</div>";// task
    }