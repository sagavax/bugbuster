<?php
    include "includes/dbconnect.php";
    include "includes/functions.php";


    $application  =  $_POST['application'];
    $get_bugs = "SELECT * from ideas WHERE application='$application'";
    $result = mysqli_query($link, $get_bugs) or die(mysqli_error($link));
 
    
    while ($row = mysqli_fetch_array($result)) {
        $idea_id = htmlspecialchars($row['idea_id'] ?? '', ENT_QUOTES, 'UTF-8');
        $idea_title = htmlspecialchars($row['idea_title'] ?? '', ENT_QUOTES, 'UTF-8');
        $idea_text = htmlspecialchars($row['idea_text'] ?? '', ENT_QUOTES, 'UTF-8');
        $idea_priority = htmlspecialchars($row['priority'] ?? '', ENT_QUOTES, 'UTF-8');
        $idea_status = htmlspecialchars($row['status'] ?? '', ENT_QUOTES, 'UTF-8');
        $is_applied = htmlspecialchars($row['is_applied'] ?? '', ENT_QUOTES, 'UTF-8');
        $added_date = htmlspecialchars($row['added_date'] ?? '', ENT_QUOTES, 'UTF-8');
        $application = htmlspecialchars($row['application'] ?? '', ENT_QUOTES, 'UTF-8');
      
            echo "<div class='idea' idea-id=$idea_id>";
                  //echo "<form action='' method='post'>";
                  echo "<div class='idea_title'>$idea_title</div>";
                  echo "<div class='idea_text'>$idea_text</div>";
                  echo "<div class='idea_footer'>";
                  
                    echo "<input type='hidden' name='idea_id' value=$idea_id>";
                    echo "<input type='hidden' name='is_applied' value=$is_applied>";
                    $nr_of_comments = GetCountIdeaComments($idea_id);
                    echo "<div class='nr_of_comments'>$nr_of_comments comment(s)</div>";
                    echo "<div class='idea_status'>$idea_status</div><div class='idea_priority $idea_priority'>$idea_priority</div>";
                    echo "<button type='submit' name='see_idea_details' class='button small_button'><i class='fa fa-eye'></i></button>";
                    
      
                 if($is_applied==0){
                    echo "<button type='submit' name='delete_idea' class='button small_button'><i class='fa fa-times'></i></button>";
                      echo "<button type='submit' name='to_apply' class='button small_button'><i class='fa fa-check'></i></button>";
                        
                  } else {
      
                        echo "<div class='span_modpack'>applied</div>";
                  }        
      
      
                  //echo "</form>";      
                  echo "</div>";
            echo "</div>"; // idea
      }                             
                        
                      