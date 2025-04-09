<?php include "includes/dbconnect.php";
      include "includes/functions.php";
      
        $comment_header = mysqli_real_escape_string($link, $_POST['comment_title']);
        $comment = mysqli_real_escape_string($link, $_POST['comment']);
        $idea_id = $_POST['idea_id'];
         //var_dump($_POST);


        $save_comment = "INSERT into ideas_comments (idea_id,idea_comm_header, idea_comment, comment_date) VALUES ($idea_id,'$comment_header','$comment',now())";
        //echo $save_comment;
         $result=mysqli_query($link, $save_comment);
         
	      
        $diary_text="Minecraft IS: Bolo pridany novy kommentar k idei id <b>$idea_id</b>";
        $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
        $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
        //echo "<script>message('Comment added','success')</script>";
        //header("location:idea.php");
        exit;