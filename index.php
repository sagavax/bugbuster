<?php session_start();

include("includes/dbconnect.php"); 
 
      include "includes/dbconnect.php";
      include "includes/functions.php";
      header("Cache-Control: max-age=0");

      if(isset($_POST['login'])){
        $username=mysqli_real_escape_string($link, $_POST['username']);
        $password=mysqli_real_escape_string($link, $_POST['password']);
       
            
      $sql="select * from users where user_id = '$username' and password = '$password'";
      //echo $sql;
      //$row = mysqli_fetch_array($link,$result);
      $result = mysqli_query($link,$sql);
      $overeni = mysqli_num_rows($result);
      //echo "Pocet riadkov:".$overeni;
      
      if($overeni == 1) {
          $row = mysqli_fetch_array($result);
          echo "<div class='overlay'><div class='logon_information success'><i class='fa fa-check-circle'></i></div></div>"; 
          echo "<script>setTimeout(function(){
            window.location = 'dashboard.php';
          }, 3000)</script>";

          //header("location:dashboard.php");
          } elseif ($overeni==0) {
            echo "<div class='overlay'><div class='logon_information error'><i class='fas fa-times-circle'></i></div></div>";
            echo "<script>setTimeout(function(){
              window.location = 'index.php';
            }, 3000)</script>";
            /*echo "<script>alert('Bad username or password');
         location.href='index.php';</script>";*/
          }
      }

?>


<!DOCTYPE html>
<!-- saved from url=(0047)file:///C:/wamp/www/eis/materialize/index.html# -->
<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
         <meta name="viewport" content="width=device-width,initial-scale=1">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
        <link href="css/login.css?<?php echo time(); ?>" rel="stylesheet">
        <title>BugBuster - bug / ideas tracker</title>
        <link rel='shortcut icon' href='letter-b.png'>
</head>
<body>

        <div class="login-page">
          <div class="form">
           <form class="login-form" action="" method="post">
              <input type="text" placeholder="username" name="username" autocomplete="off">
              <input type="password" placeholder="password" name="password" autocomplete="off" />
              <button name="login">login</button>
              </form>
          </div>
        </div> 

        </body>
  </html>