<?php

include "../includes/dbconnect.php";
include "../includes/functions.php";

$bug_id = $_GET['bug_id'];

$get_comments = "SELECT * from bugs_comments wHERE bug_id=$bug_id ORDER BY comm_id DESC";
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
        echo "<div class='bug_comm_action'><form action='' method='post'><input type='hidden' name='comm_id' value=$comm_id><input type='hidden' name='bug_id' value=$bug_id><button type='submit' name='delete_comm' class='button small_button'><i class='fa fa-times'></i></button></form></div>";
    echo "</div>";
 }