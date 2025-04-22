<?php 
  include "includes/dbconnect.php";
  include "includes/functions.php";  
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minecraft IS</title>
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="css/appLog.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" >
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script type="text/javascript" defer src="../js/appslog.js?<?php echo time(); ?>"></script>
    <link rel='shortcut icon' href='letter-b.png'>

  </head>
  <body>
    <div class="main">
        <?php include ("includes/header.php") ?>
           <div class="content">
              <div class="list">
              </div><!-- /.list-->
           </div><!-- /.content -->
    </div><!-- /.main-->