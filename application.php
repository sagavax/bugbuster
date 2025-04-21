<?php 
    include "includes/dbconnect.php";
    include "includes/functions.php";
 ?>
 
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="css/app.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script type="text/javascript" defer src="js/app.js?<?php echo time(); ?>"></script>
    <title>Bugbuster - application details</title>
    <link rel='shortcut icon' href='letter-b.png'>
</head>
<body>
<div class="main">
        <?php include ("includes/header.php") ?>
           <div class="content">
              <div class="list">
                 
                    <?php
                        //get list of the applicationa
                        $app_id = $_GET['app_id'];
                        $get_apps = "SELECT * FROM apps WHERE app_id=$app_id";
                        $result_apps = mysqli_query($link, $get_apps) or die(mysqli_error($link));
                            while ($row_apps = mysqli_fetch_array($result_apps)) {
                                $app_id = $row_apps['app_id'];
                                $app_name = $row_apps['app_name'];
                                $app_desc = $row_apps['app_descr'];
                                $app_github_repo = $row_apps['github_repo'];
                                $app_active_dev = $row_apps['is_active_dev'];
                                $app_is_active = $row_apps['is_app_active'];
                                echo "<div class='application' data-app-id=$app_id>";
                                    //echo "<div class='connector-line'></div>";
                                    //echo "<div class='app-icon'>$app_icon</div>";
                                    //echo "<div class='app-info'>";
                                        echo "<input type='text' name='app_name' autocomplete='off' value='$app_name'>";
                                        echo "<textarea name='app_description'>$app_desc</textarea>";
                                        
                                        echo "<div class='app-actions'>";
                                            echo "<button type='button' name='app_save_changes' class='button small_button'><i class='fa fa-plus'></i></button>";
                                            //echo "<button type='button' name='edit_app' class='button small_button'><i class='fa fa-edit'></i></button>";
                                        echo "</div>";
                                echo "</div>";
                        }
                    ?>
                
                    <div class="application_details">
                        <div class="application_details_header">
                            <h3>Application details</h3>
                            <div class="application_details_tabs">
                                <button type="button" name="github_link" class="button small_button">Github</button>
                                <button type="button" name="app_diary" class="button small_button">Diary</button>
                                <button type="button" name="app_notes" class="button small_button">Notes</button>
                                <button type="button" name="app_bugs" class="button small_button">Bugs</button>
                                <button type="button" name="app_ideas" class="button small_button">Ideas</button>
                            </div><!-- application_details_header_actions -->
                        </div><!-- application_details_header -->
                        <div class="application_details_body">
                        </div>    
                    </div><!-- application_details -->    
              </div><!-- list-->
            </div><!-- content -->      
    </div><!-- main -->

</body>
</html>