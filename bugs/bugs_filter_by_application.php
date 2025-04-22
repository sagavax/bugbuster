<?php
    include "../includes/dbconnect.php";
    include "../includes/functions.php";


    $application  =  $_POST['application'];
    $get_bugs = "SELECT * from bugs WHERE bug_application='$application'";
    $result = mysqli_query($link, $get_bugs) or die(mysqli_error($link));
      
    while ($row = mysqli_fetch_array($result)) {
        // Sanitizácia údajov na ochranu pred XSS
        $bug_id = (int) ($row['bug_id'] ?? 0); // ID musí byť číslo
        $bug_title = htmlspecialchars($row['bug_title'] ?? '', ENT_QUOTES, 'UTF-8');
        $bug_text = htmlspecialchars($row['bug_text'] ?? '', ENT_QUOTES, 'UTF-8');
        $bug_priority = htmlspecialchars($row['bug_priority'] ?? '', ENT_QUOTES, 'UTF-8');
        $bug_status = htmlspecialchars($row['bug_status'] ?? '', ENT_QUOTES, 'UTF-8');
        $is_fixed = (int) ($row['is_fixed'] ?? 0);
        $added_date = htmlspecialchars($row['added_date'] ?? '', ENT_QUOTES, 'UTF-8');
        $application = htmlspecialchars($row['bug_application'] ?? '', ENT_QUOTES, 'UTF-8');

    
        // Počet komentárov
        $nr_of_comments = GetCountBugComments($bug_id);
    
        // Ak je bug FIXED, zobrazí štítok + mení akčné tlačidlá
        $add_comment = "<button type='button' name='add_comment' class='button small_button' onclick='addNewComment();')><i class='fa fa-comment'></i></button>";
        $fixed_label = $is_fixed ? "<div class='span_fixed'>fixed</div>" : "";
        $action_buttons = $is_fixed ? 
            "<button type='button' name='see_bug_details' class='button small_button'><i class='fa fa-eye'></i></button>
             <button type='button' name='bug_remove' class='button small_button'><i class='fa fa-times'></i></button>
             {$add_comment}" : // Pridanie komentára aj pre fixed stav
            "<button type='button' name='see_bug_details' class='button small_button'><i class='fa fa-eye'></i></button>
             <button type='button' name='to_fixed' class='button small_button'><i class='fa fa-check'></i></button>
             <button type='button' name='bug_remove' class='button small_button'><i class='fa fa-times'></i></button>
             {$add_comment}"; // Pridanie komentára aj pre nefixed stav
        
    
        // Generovanie HTML výstupu
       
        echo "<div class='bug' bug-id='{$bug_id}'>
              <div class='bug_title'>$bug_title</div>";
         echo "<div class='bug_text'>$bug_text</div>
          <div class='bug_footer'>
              <div class='bug_application'>$application</div>                         
              <div class='bug_status $bug_status'>$bug_status</div>
              <div class='bug_priority $bug_priority'>$bug_priority</div>
              <div class='bug_comments'>$nr_of_comments comments</div>";


               if ($is_fixed == 1) {
                    echo "<div class='bug_fixed'>fixed</div>";                                  }  

           echo" <div class='bug_action'>
                    {$action_buttons}
              </div>
          </div>
      </div>";

    
    }
                        
                      