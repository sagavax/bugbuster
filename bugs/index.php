<?php include "../includes/dbconnect.php";
      include "../includes/functions.php";
?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BugBuster</title>
    <link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/bugs.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script type="text/javascript" defer src="../js/bugs.js?<?php echo time(); ?>"></script>
    <link rel='shortcut icon' href='../letter-b.png'>

  </head>
  <body>
  <div class="information_panel">
    <div class="info">Number of bugs: <span id="bug_count"><?php echo GetCountBugs(); ?></span></div>
    <div class="info">Number of fixed bugs: <span id="bug_fixed_count"><?php echo GetcountFixedBugs() ?></span></div>
    <div class="info">Number of not fixed bugs: <span id="bug_notfixed_count"><?php echo GetcountNotFixedBugs() ?></span></div>
    <div class="info">Number of low bugs: <span id="ibug_low_count"><?php echo GetcountLowPriorityBugs() ?></span></div>
    <div class="info">Number of medium bugs: <span id="ibug_medium_count"><?php echo GetcountMediumPriorityBugs() ?></span></div>
    <div class="info">Number of high bugs: <span id="ibug_high_count"><?php echo GetcountHighPriorityBugs() ?></span></div>
    <div class="info">Number of critical bugs: <span id="ibug_critical_count"><?php echo GetcountCriticalPriorityBugs() ?></span></div>
  </div>
           <div class="main">
           <?php include ("../includes/header.php") ?>
           <div class="content">
              <div class="list">
              
              <div class="new_bug">
                <form action="" method="post">
                      <input type="text" name="bug_title" placeholder="bug title here" id="bug_title" autocomplete="off">
                      <textarea name="bug_text" placeholder="Put a bug / error text here" id="markdown-input"></textarea>
                     
                      <select name="bug_application">
                          <option value=0>--- choose application --- </option>
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
                     
                      <select name="bug_priority">
                        <option value=0>--- choose priority --- </option>
                        <option value = "low">low</option>
                        <option value = "medium">medium</option>
                        <option value = "high">high</option>
                        <option value = "critical">critical</option>
                      </select>

                      <select name="bug_status">
                          <option value=0>--- choose status --- </option>
                          <option value = "new">new</option>
                          <option value = "in progress">in progress</option>
                          <option value = "pending">pending</option>
                          <option value = "fixed">fixed</option>
                          <option value = "reopened">reopened</option>
                      </select>

                      <div class="new_bug_action">
                        <button type="buttont" name="save_bug" class="button small_button">Save</button>
                      </div>
               </form>
              </div><!-- new bug-->
              
             <div class="bugs_search">
                <input type="text" id="search" placeholder="Search for bugs..." autocomplete="off">
             </div>             



              <div class="bugs_filters">             
                  <div class="bug_application_filter">
                      <?php
                          $get_application = "SELECT bug_application from bugs GROUP BY bug_application";
                          $result=mysqli_query($link, $get_application) or  die(mysqli_error($link));
                          while ($row = mysqli_fetch_array($result)) {
                                  $application = $row['bug_application'];
                                  echo "<button type='button' title='show bugs for $application' class='button small_button' data-application='$application'>$application</button>";
                          }

                      ?>
                    </div><!-- bug application filter-->
         
                    <div class="bug_status_priority_filters">
                      <div class="bug_priority_filter">
                          <?php
                            $get_priority = "SELECT bug_priority from bugs GROUP BY bug_priority";
                            $result=mysqli_query($link, $get_priority) or  die(mysqli_error($link));
                            while ($row = mysqli_fetch_array($result)) {
                                    $priority = $row['bug_priority'];
                                    echo "<button type='button' title='show bugs with priority' class='button $priority small_button ' data-priority='$priority'>$priority</button>";
                            }
                            echo "<button type='button' title='all bugs' class='button  small_button ' data-priority='all'>All</button>"; // Pridanie tlacidla pre vsetky bugy
                          ?>
                        </div><!-- bug priority filter-->
                        
                      <div class="bug_status_filter">
                        <?php
                            $get_priority = "SELECT bug_status from bugs GROUP BY bug_status";
                            $result=mysqli_query($link, $get_priority) or  die(mysqli_error($link));
                            while ($row = mysqli_fetch_array($result)) {
                                    $bug_status = $row['bug_status'];
                                    echo "<button type='button' title='show bugs with the status' class='button $bug_status small_button ' data-status='$bug_status'>$bug_status</button>";
                            }
                            echo "<button type='button' title='all bugs' class='button  small_button ' data-priority='all'>All</button>"; // Pridanie tlacidla pre vsetky bugy
                          ?>
                        </div><!-- bug status filter-->
                      </div><!-- bug status/priority filters-->
                </div><!-- bug filters-->
              

              <div class="bug_list">


                  <?php

                      $itemsPerPage = 10;

                     $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                     $offset = ($current_page - 1) * $itemsPerPage;


                        $get_bugs = "SELECT * FROM bugs WHERE bug_status not in ('fixed', 'deleted') ORDER BY bug_id DESC LIMIT $itemsPerPage OFFSET $offset";
                        $result=mysqli_query($link, $get_bugs) or  die(mysqli_error($link));
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
                          $bug_github_url = htmlspecialchars($row['bug_github_url'] ?? '', ENT_QUOTES, 'UTF-8');

                      
                          // Počet komentárov
                          $nr_of_comments = GetCountBugComments($bug_id);
                      
                          // Ak je bug FIXED, zobrazí štítok + mení akčné tlačidlá
                          $add_comment = "<button type='button' title='add comment' name='add_comment' class='button small_button' onclick='addNewComment();')><i class='fa fa-comment'></i></button>";
                          $fixed_label = $is_fixed ? "<div class='span_fixed'>fixed</div>" : "";
                          $action_buttons = $is_fixed ? 
                              "<button type='button' name='see_bug_details' title='bug details' class='button small_button'><i class='fa fa-eye'></i></button>" : // Pridanie komentára aj pre fixed stav
                              "<button type='button' name='see_bug_details' title='bug details' class='button small_button'><i class='fa fa-eye'></i></button>
                               <button type='button' name='move_to_ideas' title='move to ideas' class='button small_button'><i class='fas fa-chevron-right'></i></button>
                               <button type='button' name='to_fixed' title='mark as fixed' class='button small_button'><i class='fa fa-check'></i></button>
                               <button type='button' name='bug_remove' title='remove bug' class='button small_button'><i class='fa fa-times'></i></button>
                               {$add_comment}"; // Pridanie komentára aj pre nefixed stav
                          
                      
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


                                 if ($is_fixed == 1) {
                                      echo "<div class='bug_fixed'>fixed</div>";                                  }  

                             echo" <div class='bug_action'>
                                      {$action_buttons}
                                </div>
                            </div>
                        </div>";

                      
                      }
                           
                  ?>
              </div>
                  <?php
                    // Calculate the total number of pages
                    $sql = "SELECT COUNT(*) as total FROM bugs";
                    $result = mysqli_query($link, $sql);
                    
                    $totalItems = 0; // Predvolene nulová hodnota
                    
                    if ($row = mysqli_fetch_array($result)) {
                        $totalItems = (int) $row['total']; // Zaistenie, že hodnota je celé číslo
                    }
                    
                    // Výpočet počtu strán
                    $totalPages = ($totalItems > 0) ? ceil($totalItems / $itemsPerPage) : 1;
                    
                    // Zobrazenie stránkovania
                    echo '<div class="pagination">';
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo '<a href="?page=' . $i . '">' . $i . '</a>'; // Opravené úvodzovky
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
          <li>fixed</li>
          <li>reopened</li>
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
      <button type="submit" name="add_comment" class="button small_button">Add</button>
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

    <dialog id="modal-add-label">
      <div class="label-buttons">
        <button class="label-btn" data-label="duplicate">duplicate</button>
        <button class="label-btn" data-label="invalid">invalid</button>
        <button class="label-btn" data-label="irrelevant">Irrelevant</button>
        <button class="label-btn" data-label="fixed elsewhere">fixed elsewhere</button>
        <button class="label-btn" data-label="lack information">lack information</button>
      </div>
    </dialog>        

  </body>
  </html> 
