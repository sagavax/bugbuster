<?php

include "includes/dbconnect.php";    
include "includes/functions.php";   

$app_id = $_GET['application_id'];

$get_records = "SELECT * from diary WHERE project_id=$app_id";
$result = mysqli_query($link, $get_records) or die(mysql_error($link));

while ($row = mysqli_fetch_array($result)) {
  $diary_date = $row['created_date'];
  $diary_text = $row['diary_text'];
  $app_id = $row['project_id'];
  $diary_app = GetAppName($app_id);

  echo "<div class='diary_record' data-id='" . $row['id'] . "'>
          <div class='diary_text'>$diary_text</div>
          <div class='diary_app'><span class='app_name'>$diary_app<span></div>
          <div class='diary_action'><button class='button button_small' name='delete_record'><i class='fa fa-times'></i></button></div>
        </div>";
}
?>                    