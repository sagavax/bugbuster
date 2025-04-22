      <?php include "../includes/dbconnect.php";
      
      $bug_id = $_POST['bug_id'];   

      //set bug as fixed
      $bug_to_fix = "UPDATE bugs SET is_fixed=1 WHERE bug_id=$bug_id";
      $result=mysqli_query($link, $bug_to_fix);

      //change status
      $bug_change_status = "UPDATE bugs SET bug_status='fixed' WHERE bug_id=$bug_id";
      $result=mysqli_query($link, $bug_change_status);   

      //set date fixed
      $set_date_fixed = "UPDATE bugs SET date_fixed=now() WHERE bug_id=$bug_id";
      $result=mysqli_query($link, $set_date_fixed);
          
      //add to audit log
      $diary_text="Bug s id $bug_id bol fixnuty";
      $create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
      $result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));
            
      //add to timeline
      $diary_text="Bug bol fixnuty";
      $create_record="INSERT INTO bugs_timeline (object_id, object_type,parent_object_id, timeline_text, created_date) VALUES ($bug_id,'bug',$bug_id,'$diary_text', now())";
      $result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));