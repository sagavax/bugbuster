<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BugBuster - dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="css/dashboard.css?<?php echo time(); ?>">
    <link rel='shortcut icon' href='letter-b.png'>
</head>
<body>
    <div class="main">
        <?php include ("includes/header.php") ?>
        <div class="dashboard">
          <div class="small_dashboard">  
          <div class="dash-item" dash-item="applications">
                Applications
            </div>    
          <div class="dash-item" dash-item="bugs">
                Bugs
            </div>  
            <div class="dash-item" dash-item="ideas">
                Ideas
            </div>
            <div class="dash-item" dash-item='logs'>
                Logs
            </div>  
            <div class="dash-item" dash-item="about">
                About
            </div>
            <div class="dash-item" dash-item="logou">
                Logout
            </div>
        </div>
        
        <div class="small_dashboard_2">  
          <div class="dash-item" dash-item="applications">
                Applications
            </div>    
          <div class="dash-item" dash-item="bugs">
                Bugs
            </div>  
            <div class="dash-item" dash-item="ideas">
                Ideas
            </div>
            <div class="dash-item" dash-item='logs'>
                Logs
            </div>  
            <div class="dash-item" dash-item="about">
                About
            </div>
            <div class="dash-item" dash-item="logou">
                Logout
            </div>
        </div>


        </div><!--dashboard-->
    </div><!-- main -->
</body>
</html>