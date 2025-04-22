<?php include "../includes/dbconnect.php";
      include "../includes/functions.php";
      session_start();


      if(isset($_POST['reopen_bug'])){
        $bug_id = $_SESSION['bug_id'];
        $_SESSION['is_fixed']=0;
        $reopen_bug = "UPDATE bugs set is_fixed = 0 wHERE bug_id=$bug_id";
        //echo $reopen_bug;
        $result=mysqli_query($link, $reopen_bug);

       
        $diary_text="Bug s id <b>$bug_id</b> bol znovu otvoreny";
        $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
        $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
        
      }
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
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <script type="text/javascript" defer src="../js/bug.js?<?php echo time(); ?>"></script>
    <link rel='shortcut icon' href='../letter-b.png'>

  </head>
  <body>
        <?php include("../includes/header.php") ?>   
      <div class="main">
         <div class="content">
               <div class="fab fab-icon-holder" onclick="window.location.href='index.php';">
                <i class="fa fa-arrow-left"></i>
              </div>
              <div class="list">
                  <?php
                        $bug_id = $_GET['bug_id'];
                        $get_bug = "SELECT * from bugs WHERE bug_id =$bug_id";
                        $result=mysqli_query($link, $get_bug) or  die();
                        while ($row = mysqli_fetch_array($result)) {
                              $bug_id = $row['bug_id'];
                              $bug_title = $row['bug_title'];
                              $bug_text = $row['bug_text'];
                              $is_fixed = $row['is_fixed'];
                              $added_date = $row['added_date'];
                              $application = $row['bug_application'];

                              echo "<div class='bug'>";
                                    echo "<div class='bug_title'>$bug_title</div>";
                                    echo "<div class='bug_text'>$bug_text</div>";
                                    echo "<div class='bug_footer'>";
                                       echo "<div class='bug_added_date'>$added_date</div><div class='bug_application'>$application</div>";   
                                       if($is_fixed==0){
                                                echo "<button type='button' title='mark the bug as fixed' name='bug_set_fixed' class='button small_button'><i class='fa fa-check'></i></button>";
                                          
                                    } elseif ($is_fixed==1){

                                          echo "<button type='button' title='mark the bug as fixed' class='button small_button' name='reopen_bug'>Reopen</button><div class='bug_fixed'>fixed</div>";
                                    }        

                                          
                                    echo "</div>";
                              echo "</div>"; // bug
                        }      
                  ?>

                    <div class="bug_comments_list">
                              <?php

                                $get_comments = "SELECT * from bugs_comments wHERE bug_id=$bug_id";
                                $result_comment=mysqli_query($link, $get_comments);
                                 while ($row_comment = mysqli_fetch_array($result_comment)) {
                                    $comm_id = $row_comment['comm_id'];
                                    $comm_title = $row_comment['bug_comm_header'];
                                    $comm_text = $row_comment['bug_comment'];
                                    $comm_date = $row_comment['comment_date'];

                                    echo "<div class='bug_comment'>";
                                        echo "<div class='connector-line'></div>";
                                        echo "<div class='bug_top_banner'></div>";
                                        if($comm_title!=""){
                                            echo "<div class='bug_title'>$comm_title</div>";    
                                        }
                                        echo "<div class='bug_text'>$comm_text</div>";
                                        echo "<div class='bug_comm_action'><button type='button' name='delete_comment' class='button small_button'><i class='fa fa-times'></i></button></form></div>";
                                    echo "</div>";
                                 }   
                              ?>  
                         </div><!-- bug comment list-->    
                         <div class="bug_comment_new">
                            <form action="" method="post">
                                <h4>Add a comment</h4>  
                                  <input type="hidden" name="bug_id" value="<?php echo $bug_id?>">
                                  <input type="text" name="bug_comment_header" autocomplete="off" placeholder="type title here">
                                  <textarea name="bug_comment" placeholder="type comment here..."></textarea>
                                  
                                  <div class="bug_comment_action">
                                    <?php
                                          if($is_fixed==0){
                                              echo "<button name='save_comment' class='button small_button'>save</button>";
                                          } else if ($is_fixed==1){
                                              echo "<button name='save_comment' disabled class='button small_button'>save</button>";
                                          }
                                    ?>  
                                    
                                   </div>
                                </form>   
                        </div><!--bug comment -->       
                 
              </div><!-- list-->

        </div><!--content-->
      </div><!--main_wrap-->
  </body>
  </html> 
