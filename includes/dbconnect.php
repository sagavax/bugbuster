<?php
  date_default_timezone_set('Europe/Bratislava');


 //$link = mysqli_connect("mariadb105.r6.websupport.sk", "bugbuster", "p&GY^kuK^v!zHdU", "bugbuster", 3315);
 $link = mysqli_connect("localhost", "root", "", "bugbuster", 3306);
/* 
 $dsn = 'mysql:host=mariadb105.r6.websupport.sk;dbname=minecraft_db;port=3315';
$username = 'minecraft_db';
$password = 'Us6^*qb1H-';
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
);

$pdo = new PDO($dsn, $username, $password, $options);
 */

  if (!$link) {
      echo "Error: Unable to connect to MySQL." . PHP_EOL;
      echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    exit;
  } 

//
// Setup the UTF-8 parameters:
// * http://www.phpforum.de/forum/showthread.php?t=217877#PHP
//
// header('Content-type: text/html; charset=utf-8');
/* mysqli_query($link,'set character set utf8;');
mysqli_query($link,"SET NAMES `utf8`"); */
?>
