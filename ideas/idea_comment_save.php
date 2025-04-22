<?php include "../includes/dbconnect.php";
      include "../includes/functions.php";
      
        $comment_header = mysqli_real_escape_string($link, $_POST['comment_title']);
        $comment = mysqli_real_escape_string($link, $_POST['comment']);
        $idea_id = $_POST['idea_id'];
         //var_dump($_POST);


        
        $save_comment = "INSERT into ideas_comments (idea_id,idea_comm_header, idea_comment, comment_date) VALUES ($idea_id,'$comment_header','$comment',now())";
        //echo $save_comment;
         $result=mysqli_query($link, $save_comment);
         
        
        //comments counter
        $total_comments = "UPDATE ideas SET comments = comments + 1 WHERE idea_id = $idea_id";
        //echo $total_comments;
        $result = mysqli_query($link, $total_comments) or die("MySQLi ERROR: ".mysqli_error($link));

        
         
        $diary_text="Bolo pridany novy kommentar k idei id <b>$idea_id</b>";
        $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
        $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
        //echo "<script>message('Comment added','success')</script>";
        //header("location:idea.php");
    
        
        
        //get laster comment id
        $sql = "SELECT comm_id FROM ideas_comments ORDER BY comm_id DESC LIMIT 1";
        $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));
        $row = mysqli_fetch_array($result);
        $comm_id = $row['comm_id'];
        

        //add to timeline
        $diary_text="Bol pridany novy kommentar";
        $create_record="INSERT INTO ideas_timeline (object_id, object_type, parent_object_id, timeline_text, created_date) VALUES ($comm_id, 'bug', $idea_id,'$diary_text', now())";
        $result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));   

