      <?php include "../includes/dbconnect.php";
      
      $bug_id = $_POST['bug_id'];   

      $bug_to_fix = "UPDATE bugs SET is_fixed=0 WHERE bug_id=$bug_id";
      $result=mysqli_query($link, $bug_to_fix);

      //update bug status
      $bug_change_status = "UPDATE bugs SET status='newd' WHERE bug_id=$bug_id";
      $result=mysqli_query($link, $bug_change_status);   

      //add to audit log    
      $diary_text="Bug s id $bug_id bol znovu otvreny";
      $create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
      $result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));
            
      
      //add to timeline
      $diary_text="Bug bol znovu otvoreny";
      $create_record="INSERT INTO bugs_timeline (object_id, object_type, parent_object_id, timeline_text, created_date) VALUES ($bug_id, 'bug', $bug_id,'$diary_text', now())";
      $result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));