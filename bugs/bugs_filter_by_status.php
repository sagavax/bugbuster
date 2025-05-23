<?php

include "../includes/dbconnect.php";
include "../includes/functions.php";

if(isset($_POST['status'])){
      $status  =  mysqli_real_escape_string($link,$_POST['status']);
      if($status == 'all'){

            $get_bugs = "SELECT * from bugs ORDER BY bug_id DESC"; 
      } else {
            $get_bugs = "SELECT * from bugs WHERE bug_status='$status' ORDER BY bug_id DESC";
      }       
}

$result = mysqli_query($link, $get_bugs) or die(mysqli_error($link));
                       
while ($row = mysqli_fetch_array($result)) {
      // Sanitizácia údajov na ochranu pred XSS
      $bug_id = (int) ($row['bug_id'] ?? 0); // ID musí byť číslo
      $bug_title = htmlspecialchars($row['bug_title'] ?? '', ENT_QUOTES, 'UTF-8');
      $bug_text = htmlspecialchars($row['bug_text'] ?? '', ENT_QUOTES, 'UTF-8');
      $bug_priority = htmlspecialchars($row['bug_priority'] ?? '', ENT_QUOTES, 'UTF-8');
      $bug_status = htmlspecialchars($row['bug_status'] ?? '', ENT_QUOTES, 'UTF-8');
      $added_date = htmlspecialchars($row['added_date'] ?? '', ENT_QUOTES, 'UTF-8');
      $application = htmlspecialchars($row['bug_application'] ?? '', ENT_QUOTES, 'UTF-8');
      $bug_github_url = htmlspecialchars($row['bug_github_url'] ?? '', ENT_QUOTES, 'UTF-8');

  
      // Počet komentárov
      $nr_of_comments = GetCountBugComments($bug_id);
  
      if($bug_status == "fixed") {
            $action_buttons = "<button type='button' name='see_bug_details' class='button small_button'><i class='fa fa-eye'></i></button>";
      } else if ($bug_status=="new"||$bug_status=="in progress" || $bug_status=="pending"){
            $action_buttons = "<button type='button' name='see_bug_details' class='button small_button'><i class='fa fa-eye'></i></button>
            <button type='button' name='to_fixed' class='button small_button'><i class='fa fa-check'></i></button>
            <button type='button' name='bug_remove' class='button small_button'><i class='fa fa-times'></i></button>";
      } else if ($bug_status=="deleted") {
            $action_buttons = "<button type='button' name='bug_reopen' title='Reopen / recycle bug' class='button small_button'><i class='fa fa-eye'></i></button>";
      }
            
 
      // Generovanie HTML výstupu
     
      echo "<div class='bug' bug-id='{$bug_id}'>
            <div class='bug_title'>$bug_title</div>";
       echo "<div class='bug_text'>$bug_text</div>
        <div class='bug_footer'>
            <div class='bug_github_link' data-link='$bug_github_url'><i class='fab fa-github-alt'></i></div>
            <div class='bug_application'>$application</div>                         
            <div class='bug_status $bug_status'>$bug_status</div>
            <div class='bug_priority $bug_priority'>$bug_priority</div>
            <div class='bug_comments'>$nr_of_comments comments</div>";


         echo"<div class='bug_action'>
                 {$action_buttons}  
            </div>
        </div>
    </div>";

  
  }

  ?>