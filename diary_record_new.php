<?php 
 include("include/dbconnect.php");
 include("include/functions.php");

 if(isset($_POST['add_record'])){
     $diary_text=trim(mysqli_real_escape_string($con, $_POST['diary_text']));
     $project_id=$_POST['project'];
     $curr_date=date('Y-m-d H:i:s');

     $sql="INSERT INTO diary (created_date, diary_text,project_id) VALUES ('$curr_date','$diary_text',$project_id)";
     $result = mysqli_query($con, $sql) or die("MySQLi ERROR: ".mysqli_error($con));

     //pridanie do wallu
     if($project_id==0){
         $project_name="";
         $wall_text="Developersky dennik: $diary_text";
     } else {
     $project_name=GetAppName($project_id);
     $project_name=mysqli_real_escape_string($con,$project_name);
     $app_hashtag=GetAppHashTag($project_id);

     $wall_text="Developersky dennik: aplikacia <strong>$project_name</strong>: $diary_text $app_hashtag";
    }

    $link1 = mysqli_connect(null, "brick_wall", "h3jSXv3gLf", "brick_wall", null, "/tmp/mariadb55.sock");
     $sql="INSERT INTO diary (diary_text, date_added,location,isMobile,is_read) VALUES ('$wall_text','$curr_date','',0,0)";
     $result = mysqli_query($link1, $sql) or die("MySQLi ERROR: ".mysqli_error($link1));
	 mysqli_close($link1);

     //alert
     echo "<script>alert('Bol pridany novy zaznam');
     window.location.href='index.php';
     </script>";

 }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pridat novy zaznam</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css?<?php echo time(); ?>" />
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>

</head>
<body>
    <div id="container">
        <h3>Pridat novy zaznam</h3>
        <form action="" method="post">
            <textarea name="diary_text"></textarea>
            <select name="project">
               <option value="0">-- All -- </option>
               <?php 
                     $dbname     = "app_manager";
                     $dbserver   = "mariadb101.websupport.sk";
                     $dbuser     = "app_manager";
                     $dbpass     = "ZljaMxcUux";
                     $link = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname,3312);

                     $sql="SELECT * from app_list";
                     $result=mysqli_query($link, $sql) ;
                        while ($row = mysqli_fetch_array($result)) {
                            $app_name=$row['app_name'];
                            $app_id=$row['app_id'];
                        echo "<option value=$app_id>$app_name</option>";
                    }   
                     mysqli_close($link);
                ?>
            </select>
            <button name="add_record" type="submit" class="green-button">+ Add</button>
    </div>    
</body>
</html>