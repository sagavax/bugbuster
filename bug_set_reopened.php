      <?php include "includes/dbconnect.php";
      
            $bug_id = $_POST['bug_id'];   

            $bug_to_fix = "UPDATE bugs SET is_fixed=0 WHERE bug_id=$bug_id";
            $result=mysqli_query($link, $bug_to_fix);

          
      $diary_text="Minecraft IS: Bug s id $bug_id bol znovu otvoreny";
      $create_record="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text', now())";
      $result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));
            
      