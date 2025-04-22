<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="main">
        <?php include ("../includes/header.php") ?>
           <div class="content">
              <div class="list">
                 <div class="application_edit">    
                    <?php
                        //get list of the applicationa
                        $app_id = $_GET['app_id'];
                        $get_apps = "SELECT * FROM apps WHERE app_id=$app_id";
                        $result_apps = mysqli_query($link, $get_apps) or die(mysqli_error($link));
                            while ($row_apps = mysqli_fetch_array($result_apps)) {
                                $app_id = $row_apps['app_id'];
                                $app_name = $row_apps['app_name'];
                                $app_desc = $row_apps['app_descr'];
                                $app_active_dev = $row_apps['is_active_dev'];
                                $app_is_active = $row_apps['is_app_active'];
                                echo "<div class='application' data-app-id=$app_id>";
                                    //echo "<div class='connector-line'></div>";
                                    echo "<div class='app-icon'>$app_icon</div>";
                                    echo "<div class='app-info'>";
                                        echo "<input type='text' name='app_name' autocomplete='off'>$app_name</inp>";
                                        echo "<textarea name='app_description'>$app_desc</textarea>";
                                        echo "</div>";
                                        echo "<div class='app-actions'>";
                                          echo "<button type='button' name='app_save_changes' class='button small_button'><i class='fa fa-pluss'></i></button>";
                                          //echo "<button type='button' name='edit_app' class='button small_button'><i class='fa fa-edit'></i></button>";
                                        echo "</div>";
                                echo "</div>";
                        }
                    ?>
                </div><!-- application_list-->
              </div><!-- list-->
            </div><!-- content -->      
    </div><!-- main -->

</body>
</html>