<?php include ("../includes/dbconnect.php");
    include ("../includes/functions.php");
?>    


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/tasks.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script type="text/javascript" defer src="../js/tasks.js?<?php echo time(); ?>"></script>
     <link rel='shortcut icon' href='../letter-b.png'>
</head>
<body>
    <div class="main">
        <?php include ("../includes/header.php") ?>
           <div class="content">
              <div class="list">
                <h2>New Task</h2>
               <div class="new_task">                    
                    <form action="task_create.php" method="post">
                        <input type="text" placeholder="task title" name="task_title" autocomplete="off">
                        <textarea placeholder="task description...." name="task_description"></textarea> 
                         <select name="task_application">
                            <option value="0">--- choose application --- </option>
                            <?php
                            $get_apps = "SELECT * from apps ORDER BY app_name ASC";
                            $result_apps = mysqli_query($link, $get_apps) or die(mysqli_error($link));
                            while ($row_apps = mysqli_fetch_array($result_apps)) {
                                $app_id = $row_apps['app_id'];
                                $app_name = $row_apps['app_name'];
                                echo "<option value =".strtolower($app_name).">$app_name</option>";
                            }
                            ?>
                        </select>
                        <select name="task_priority">
                            <option value="low">low</option>
                            <option value="medium">medium</option>
                            <option value="high">high</option>
                            <option value="critical">critical</option>
                        </select>

                        <select name="task_status">
                            <option value="new">new</option>
                            <option value="in_progress">in progress</option>
                            <option value="pending">pending</option>
                            <option value="fixed">fixed</option>
                            <option value="reopened">reopened</option>
                        </select>
                       
                        <div class="new_task_action">
                            <button type="submit" name="save_task" class="button small_button">Save</button>
                        </div>
                    </form>
                </div><!-- /.new_task -->

                 <div class="tasks_search">
                <input type="text" id="search" placeholder="Search for tasks..." autocomplete="off">
             </div> 
               
              <div class="tasks_filters">
                  <div class="task_application_filter">
                      <?php
                          $get_application = "SELECT task_application from tasks GROUP BY task_application";
                          $result=mysqli_query($link, $get_application) or  die(mysqli_error($link));
                          while ($row = mysqli_fetch_array($result)) {
                                  $application = $row['task_application'];
                                  echo "<button type='button' title='show bugs for $application' class='button small_button' data-application='$application'>$application</button>";
                          }

                      ?>
                    </div><!-- task application filter-->
                          
                    <div class="task_status_priority_filters">
                        <div class="task_priority_filter">
                          <?php
                              $get_priority = "SELECT task_priority from tasks GROUP BY task_priority";
                              $result=mysqli_query($link, $get_priority) or  die(mysqli_error($link));
                              while ($row = mysqli_fetch_array($result)) {
                                      $priority = $row['task_priority'];
                                      echo "<button type='button' title='show bugs with priority' class='button $priority small_button ' data-priority='$priority'>$priority</button>";
                              }
                            echo "<button type='button' title='all tasks' class='button  small_button ' data-priority='all'>All</button>"; // Pridanie tlacidla pre vsetky idey
                          ?>
                        </div><!-- task priority filter-->

                        <div class="task_status_filter">
                        <?php
                          $get_priority = "SELECT task_status from tasks GROUP BY task_status";
                          $result=mysqli_query($link, $get_priority) or  die(mysqli_error($link));
                          while ($row = mysqli_fetch_array($result)) {
                                  $task_status = $row['task_status'];
                                  echo "<button type='button' title='show tasks with the status' class='button $task_status small_button ' data-status='$task_status'>$task_status</button>";
                          }
                          echo "<button type='button' title='all bugs' class='button  small_button ' data-priority='all'>All</button>"; // Pridanie tlacidla pre vsetky bugy
                        ?>      
                        </div><!-- task status filter-->    
                    </div><!-- task status priority filters-->         
              </div><!-- tasks filters-->   



                <div class="tasks">
                    <h3>Tasks</h3>
                    <div class="tasks_list">
                        <?php
                        $get_tasks = "SELECT * from tasks ORDER BY task_id DESC";
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
                        ?>
                    </div>
                </div><!-- /.tasks -->

              </div><!-- /.list-->
           </div><!-- /.content -->
    </div><!-- /.main -->  
      <dialog class="modal_show_status">
        <ul>
          <li>new</li>
          <li>in progress</li>
          <li>pending</li>
          <li>applied</li>
        </ul>
    </dialog>

    <dialog class="modal_show_priority">
      <ul>
        <li>low</li>
        <li>medium</li>
        <li>high</li>
        <li>critical</li>
      </ul> 
    </dialog>

    <dialog class="modal_add_comment">
      <textarea name="comment_text" placeholder="Add a comment here"></textarea>
      <button type="button" name="add_comment" class="button small_button">Add</button>
    </dialog>        
    
    <dialog class="modal_change_app">
       <?php
            echo "<ul>";
            $get_apps = "SELECT * FROM apps";
            $result_apps = mysqli_query($link, $get_apps) or die(mysqli_error($link));
            while ($row_apps = mysqli_fetch_array($result_apps)) {
                $app_id = $row_apps['app_id'];
                $app_name = $row_apps['app_name'];
                echo "<li data-app-id=$app_id>$app_name</li>";
            } 
            echo "</ul>";          
            ?>          
    </dialog>
