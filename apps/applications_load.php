<?php

include "../includes/dbconnect.php";

$get_apps = "SELECT * FROM apps ";
$result_apps = mysqli_query($link, $get_apps) or die(mysqli_error($link));
while ($row_apps = mysqli_fetch_array($result_apps)) {
  $app_id = $row_apps['app_id'];
  $app_name = $row_apps['app_name'];
  $app_hort_name = $row_apps['app_short_name'];
  $app_desc = $row_apps['app_descr'];
  $app_github_repo = $row_apps['github_repo'];
  $app_active_dev = $row_apps['is_active_dev'];
  $app_is_active = $row_apps['is_app_active'];
  $app_icon = substr($app_name,0,1);
  echo "<div class='application' data-app-id=$app_id>";
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
  echo "</div>";
}                     