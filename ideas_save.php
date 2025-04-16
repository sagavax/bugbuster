<?php include "includes/dbconnect.php";
      include "includes/functions.php";
      session_start();
           //var_dump($_POST);
           $idea_title = mysqli_real_escape_string($link, $_POST['idea_title']);
            $idea_text = mysqli_real_escape_string($link,$_POST['idea_text']);
            //$idea_application = mysqli_real_escape_string($link,$_POST['idea_application']);
            
            $idea_application = (isset($_POST['idea_appliacation']) && $_POST['idea_appliacation'] != 0) ? mysqli_real_escape_string($link,$_POST['idea_appliacation']) : 'bugbuster';
            $idea_priority = (isset($_POST['idea_priority']) && $_POST['idea_priority'] != 0) ? mysqli_real_escape_string($link,$_POST['idea_priority']) : 'low';
            $idea_status = (isset($_POST['idea_status']) && $_POST['idea_status'] != 0) ? mysqli_real_escape_string($link,$_POST['bug_status']) : 'new';
    
            //get last idea id 
            $get_latest_idea = "SELECT idea_id FROM ideas ORDER BY idea_id DESC LIMIT 1";
            $result = mysqli_query($link, $get_latest_idea) or die("MySQLi ERROR: ".mysqli_error($link));
            $row = mysqli_fetch_array($result);
            $last_idea_id = $row['idea_id'];
            //$idea_priority = $priority."-".$last_idea_id;

            $is_applied = 0;

           //var_dump($_POST);

            $save_idea = "INSERT INTO ideas (idea_title, idea_text, idea_priority, idea_status, idea_application, is_implemented, added_date) VALUES ('$idea_title','$idea_text', '$idea_priority','$idea_status', '$idea_application',0,now())";
            echo $save_idea;
            $result=mysqli_query($link, $save_idea) or die("MySQLi ERROR: ".mysqli_error($link));

            
      
        $diary_text="Bola vytvorena nova idea s id <strong> $last_idea_id </strong>"; 
        $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
        $result = mysqli_query($link, $sql) or die("MySQLi ERROR: ".mysqli_error($link));

        echo "<script>alert('Minecraft IS: Idea bola vytvorena');
        window.location.href='ideas.php';
        </script>";