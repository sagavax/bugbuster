<?php
    include("../includes/dbconnect.php");

    $idea_id  =  $_POST['idea_id'];

    $get = "SELECT a.comm_id, a.idea_id, a.idea_comm_header, a.idea_comment, a.comment_date, b.is_implemented from ideas_comments a, ideas b WHERE a.idea_id=$idea_id and b.idea_id=a.idea_id";
    $result = mysqli_query($link, $get) or die(mysqli_error($link));

    while ($row = mysqli_fetch_array($result)){

        $comment_id = $row['comm_id'];
        $comm_title = $row['idea_comm_header'];
        $comm_text = $row['idea_comment'];
        $comm_date = $row['comment_date'];
        $is_implemented = $row['is_implemented'];

        echo "<div class='idea' data-comment-id=$comment_id>";
        echo "<div class='connector-line'></div>";
        echo "<div class='idea_top_banner'></div>";
        
        if($comm_title!=""){
            echo "<div class='idea_comm_title'>$comm_title</div>";    
        }
        echo "<div class='idea_comm_text'>$comm_text</div>";
        echo "<div class='idea_comm_action'>";

        if ($is_implemented == 1) {
                  // If $is_disabled is 1, add the disabled attribute to the button
                  echo "<button type='button' name='delete' class='button small_button' disabled><i class='fa fa-times'></i></button>";
              } else {
                  // If $is_disabled is not 1, do not add the disabled attribute
                  echo "<button type='button' name='delete' class='button small_button'><i class='fa fa-times'></i></button>";
              }
              echo "</div>";
    echo "</div>";
    }
