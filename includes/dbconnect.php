<?php
  date_default_timezone_set('Europe/Bratislava');



 $link = mysqli_connect("localhost", "root", "", "bugbuster", 3306);

  if (!$link) {
      echo "Error: Unable to connect to MySQL." . PHP_EOL;
      echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    exit;
  } 

?>
