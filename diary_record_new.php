<?php 
 include("includes/dbconnect.php");
 include("includes/functions.php");
 
 echo "<link rel='shortcut icon' href='letter-b.png'>";

 if(isset($_POST['save_record'])){
     $diary_text=trim(mysqli_real_escape_string($link, $_POST['diary_text']));
     if(isset($_POST['diary_application'])&& $_POST['diary_application'] != 0){
         $project_id = $_POST['diary_application'];
     } else {
         $project_id = 1;
     }
     //$project_id=$_POST['diary_application'];
     
     $create_record="INSERT INTO diary (created_date, diary_text,project_id) VALUES (now(),'$diary_text',$project_id)";
     $result = mysqli_query($link, $create_record) or die("MySQLi ERROR: ".mysqli_error($link));

     //pridanie do wallu
     
     //add to app logu
     $diary_text="Bol pridany novy zaznam";
     $sql="INSERT INTO app_log (diary_text, date_added) VALUES ('$diary_text',now())";
     $result = mysqli_query($link, $sql) or die(mysql_error($link));
    
     //alert
     //echo "<script>window.location.href='diary.php'</script>";
     header("location:diary.php");
 }
 ?>