<?php 
  include "../includes/dbconnect.php";
  include "../includes/functions.php";  
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BugBuster</title>
    <link rel="stylesheet" href="../css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/apps.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/bugs.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script type="text/javascript" defer src="../js/app_tabs.js?<?php echo time(); ?>"></script>
    <link rel='shortcut icon' href='../letter-b.png'>

</head>

<body>
    <div class="main">
        <?php include ("../includes/header.php") ?>
        <div class="content">
            <div class="application_wrap">
                <div class="sidebar">
                    <div class="sidebar_header">
                        <h4>Application List</h4>
                        <button type="button" name="add_app" class="button small_button"><i class="fas fa-plus"></i></button>
                    </div><!-- sidebar_header-->
                    <div class="application_list">
                        <?php
                            //get list of the applicationa
                            $get_apps = "SELECT * FROM apps WHERE is_active_dev=1";
                            $result_apps = mysqli_query($link, $get_apps) or die(mysqli_error($link));
                                while ($row_apps = mysqli_fetch_array($result_apps)) {
                                    $app_id = $row_apps['app_id'];
                                    $app_name = $row_apps['app_name'];
                                    $app_desc = $row_apps['app_descr'];
                                    $app_github_repo = $row_apps['github_repo'];
                                    $app_active_dev = $row_apps['is_active_dev'];
                                    $app_is_active = $row_apps['is_app_active'];
                                    $app_icon = substr($app_name,0,1);
                                    echo "<button type='button' name='app_details' class='button small_button' data-app-id=$app_id data-app-name=".strtolower($app_name).">".strtolower($app_name)."</button>";
                                /*  echo "<div class='application' data-app-id=$app_id data-app-name=".strtolower($app_name).">";
                                        //echo "<div class='connector-line'></div>";
                                        echo "<div class='app-icon'>$app_icon</div>";
                                        echo "<div class='app-info'>";
                                            echo "<h3>$app_name</h3>";
                                            echo "<p>$app_desc</p>";
                                            echo "</div>";
                                            echo "<div class='app-actions'>";
                                            echo "<button type='button' name='github_link' class='button small_button'><i class='fab fa-github'></i></button>";  
                                            echo "<button type='button' name='app_details' class='button small_button'><i class='fa fa-eye'></i></button>"; 
                                            echo "<button type='button' name='app_deactivate_dev' class='button small_button'><i class='fa fa-times'></i></button>";
                                            echo "<button type='button' name='edit_app' class='button small_button'><i class='fa fa-edit'></i></button>";
                                            echo "</div>";
                                    echo "</div>"; */
                            }
                        ?>
                    </div><!-- application_list-->
                </div><!-- sidebar-->
                
                <div class="application_details">
                    <div class="app_tabs">
                        <button type="button" name="app_overview" class="button small_button">Overview</button>
                        <button type="button" name="app_notes" class="button small_button">Notes</button>
                        <button type="button" name="app_bugs" class="button small_button">Bugs</button>
                        <button type="button" name="app_ideas" class="button small_button">Ideas</button>
                        <button type="button" name="app_diary" class="button small_button">Diary</button>
                        <button type="button" name="app_github" class="button small_button">github</button>
                    </div><!-- app_tabs-->
                    <div class="app_content">

                    </div>            
                </div><!-- application_details-->
            </div><!-- application_wrap-->
        </div><!-- content -->

            <div class="list">
                <div class="add_new_app_button"><button type="button" class="button small_button"
                        onclick="document.querySelector('.add_new_app_dialog').showModal();"><i
                            class="fa fa-plus"></i></button></div>
                
            </div><!-- list-->
        </div><!-- content -->
    </div><!-- main -->


    <dialog class="add_new_app_dialog">
        <div class="inner_wrap">
            <input type="text" placeholder="App Name" name="app_name" autocomplete="off">
            <input type="text" placeholder="App short name" name="app_short_name" autocomplete="off">
            <textarea placeholder="App Description" name="app_desc"></textarea>
            <div class="add_new_app_action">
                <button type="submit" class="button small_button" name="add_app">Add App</button>
            </div>
            <!--add_new_ap-->
        </div><!-- inner_wrap -->
    </dialog>

    <dialog class="modal_add_github_repo">
        <div class="inner_wrap_github">
            <input type="text" placeholder="Github Repo" name="github_repo" autocomplete="off">
            <button type="button" name="add_github_repo" class="button small_button">Add</button>
        </div>
    </dialog>

</body>