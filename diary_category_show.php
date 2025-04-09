<?php 

include ("inclde/dbcnnect.php");
include ("include/functions.php");


$cat_id=$_GET['cat_id'];

$sql="SELECT * from diary where project_id=$cat_id ORDER BY id DESC";

$result = mysqli_query($con,$sql);
while ($row = mysqli_fetch_array($result)) {
   $diary_date=$row['created_date'];
                    $diary_text=$row['diary_text'];
                    $app_id=$row['project_id'];
                    
                    $diary_app=GetAppName($app_id);
                    
                    echo "<div class='diary_record'>";
                          echo "<div class='diary_date'><span class='date_time'>$diary_date</span></div><div class='diary_text'><p>$diary_text</p></div><div class='diary_app'>$diary_app</div>";  
                    echo "</div>"; 
}