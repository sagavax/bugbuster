<?php include "../includes/dbconnect.php";
      include "../includes/functions.php";
      session_start();
?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bug Buster - Ideas</title>
    <link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/ideas.css?<?php echo time(); ?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">  
    <script type="text/javascript" defer src="../js/ideas.js?<?php echo time(); ?>"></script>
    <link rel='shortcut icon' href='../letter-b.png'>

  </head>
  <body>
  
  <div class="information_panel">
    <div class="info">Number of ideas: <span id="idea_count"><?php echo GetCountIdeas(); ?></span></div>
    <div class="info">Number of implemented ideas: <span id="idea_impemented_count"><?php echo GetCountImplementedIdeas(); ?></span></div>
    <div class="info">Not implemented ideas: <span id="idea_not_impemented_count"><?php echo GetCountNotImplementedIdeas(); ?></span></div>
    <div class="info">Number of low ideas: <span id="idea_low_count"><?php echo GetCountLowPriorityIdeas(); ?></span></div>
    <div class="info">Number of medium ideas: <span id="idea_medium_count"><?php echo GetCountMediumPriorityIdeas(); ?></span></div>
    <div class="info">Number of high ideas: <span id="idea_high_count"><?php echo GetCountHighPriorityIdeas(); ?></span></div>
    <div class="info">Number of critical ideas: <span id="idea_critical_count"><?php echo GetCountCriticalPriorityIdeas(); ?></span></div>
  </div>  

  <div class="main">
           <?php include ("../includes/header.php") ?>
           <div class="content">
              <div class="list">
              <h3>Ideas / enhacements / feets for the applications</h3>
              <div class="new_idea">
                <form action="ideas_save.php" method="post">
                      <input type="text" name="idea_title" placeholder="idea title here" id="idea_title" autocomplete="off">
                      <textarea name="idea_text" placeholder="Put a your idea(s) here..." id="idea_text"></textarea>
                      
                      <select name="idea_appliacation">
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
                      
                      
                      <select name="idea_priority">
                        <option value="0">--- choose priority --- </option>
                        <option value = "low">low</option>
                        <option value = "medium">medium</option>
                        <option value = "high">high</option>
                        <option value = "critical">critical</option>
                      </select>

                      <select name="idea_status">
                          <option value="0">--- choose status --- </option>
                          <option value = "new">new</option>
                          <option value = "in progress">in progress</option>
                          <option value = "pending">pending</option>
                          <option value = "applied">applied</option>
                          <option value = "canceled">canceled</option>
                      </select>
                      <div class="new_idea_action">
                        <button type="submit" name="save_idea" class="button small_button">Save</button>
                      </div>
               </form>
              </div><!-- new idea-->

              <div class="ideas_search">
                <input type="text" id="search" placeholder="Search for ideas..." autocomplete="off">
             </div> 
               
              <div class="ideas_filters">
                  <div class="idea_application_filter">
                      <?php
                          $get_application = "SELECT idea_application from ideas GROUP BY idea_application";
                          $result=mysqli_query($link, $get_application) or  die(mysqli_error($link));
                          while ($row = mysqli_fetch_array($result)) {
                                  $application = $row['idea_application'];
                                  echo "<button type='button' title='show bugs for $application' class='button small_button' data-application='$application'>$application</button>";
                          }

                      ?>
                    </div><!-- idea application filter-->
                          
                    <div class="idea_status_priority_filters">
                        <div class="idea_priority_filter">
                          <?php
                              $get_priority = "SELECT idea_priority from ideas GROUP BY idea_priority";
                              $result=mysqli_query($link, $get_priority) or  die(mysqli_error($link));
                              while ($row = mysqli_fetch_array($result)) {
                                      $priority = $row['idea_priority'];
                                      echo "<button type='button' title='show bugs with priority' class='button $priority small_button ' data-priority='$priority'>$priority</button>";
                              }
                            echo "<button type='button' title='all ideas' class='button  small_button ' data-priority='all'>All</button>"; // Pridanie tlacidla pre vsetky idey
                          ?>
                        </div><!-- idea priority filter-->

                        <div class="idea_status_filter">
                        <?php
                          $get_priority = "SELECT idea_status from ideas GROUP BY idea_status";
                          $result=mysqli_query($link, $get_priority) or  die(mysqli_error($link));
                          while ($row = mysqli_fetch_array($result)) {
                                  $idea_status = $row['idea_status'];
                                  echo "<button type='button' title='show ideas with the status' class='button $idea_status small_button ' data-status='$idea_status'>$idea_status</button>";
                          }
                          echo "<button type='button' title='all bugs' class='button  small_button ' data-priority='all'>All</button>"; // Pridanie tlacidla pre vsetky bugy
                        ?>      
                        </div><!-- idea status filter-->    
                    </div><!-- idea status priority filters-->         
              </div><!-- ideas filters-->           

              <div class="ideas_list">
                  <?php

                          $itemsPerPage = 10;

                     $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                     $offset = ($current_page - 1) * $itemsPerPage;


                        $get_ideas = "SELECT * from ideas WHERE idea_status != 'implemented' ORDER BY idea_id DESC LIMIT $itemsPerPage OFFSET $offset";
                        $result=mysqli_query($link, $get_ideas);
                       
                        while ($row = mysqli_fetch_array($result)) {
                          $idea_id = htmlspecialchars($row['idea_id'] ?? '', ENT_QUOTES, 'UTF-8');
                          $idea_title = htmlspecialchars($row['idea_title'] ?? '', ENT_QUOTES, 'UTF-8');
                          $idea_text = htmlspecialchars($row['idea_text'] ?? '', ENT_QUOTES, 'UTF-8');
                          $idea_priority = htmlspecialchars($row['idea_priority'] ?? '', ENT_QUOTES, 'UTF-8');
                          $idea_status = htmlspecialchars($row['idea_status'] ?? '', ENT_QUOTES, 'UTF-8');
                          $is_implemented = htmlspecialchars($row['is_implemented'] ?? '', ENT_QUOTES, 'UTF-8');
                          $added_date = htmlspecialchars($row['added_date'] ?? '', ENT_QUOTES, 'UTF-8');
                          $application = htmlspecialchars($row['idea_application'] ?? '', ENT_QUOTES, 'UTF-8');

                              echo "<div class='idea' idea-id=$idea_id>";
                                    //echo "<form action='' method='post'>";
                                    echo "<div class='idea_title'>$idea_title</div>";
                                    echo "<div class='idea_text'>$idea_text</div>";
                                    echo "<div class='idea_footer'>";
                                      
                                      echo "<input type='hidden' name='idea_id' value=$idea_id>";
                                      echo "<input type='hidden' name='is_applied' value=$is_implemented>";
                                      echo "<div class='idea_application'>{$application}</div>";
                                      $nr_of_comments = GetCountIdeaComments($idea_id);
                                      echo "<div class='nr_of_comments'>$nr_of_comments comment(s)</div>";
                                      echo "<div class='idea_status'>$idea_status</div><div class='idea_priority $idea_priority'>$idea_priority</div>";
                                      echo "<button type='button' name='see_idea_details' class='button small_button'><i class='fa fa-eye'></i></button>";
                                      

                                   if($is_implemented==0){
                                      echo "<button type='button' name='delete_idea' class='button small_button'><i class='fa fa-times'></i></button>";
                                        echo "<button type='button' name='to_apply' class='button small_button'><i class='fa fa-check'></i></button>";
                                          
                                    } else {

                                          echo "<div class='idea_implemented'>Imeplemented</div>";
                                    }        


                                    //echo "</form>";      
                                    echo "</div>";
                              echo "</div>"; // idea
                        }      
                  ?>
              </div>
             <?php
                // Calculate the total number of pages
                $sql = "SELECT COUNT(*) as total FROM ideas";
                $result=mysqli_query($link, $sql);
                $row = mysqli_fetch_array($result);
                $totalItems = $row['total'];
                $totalPages = ceil($totalItems / $itemsPerPage);

                // Display pagination links
                echo '<div class="pagination">';
                for ($i = 1; $i <= $totalPages; $i++) {
                    echo '<a href="?page=' . $i . '"">' . $i . '</a>';
                      //echo '<a href="?page=' . $i . '" class="button app_badge">' . $i . '</a>';
                }
                echo '</div>';
             ?>
            </div><!-- list-->

        </div><!--content-->
      </div><!--main_wrap-->
      
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


  </body>
  </html> 
