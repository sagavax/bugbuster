<?php

include('../includes/dbconnect.php');
include('../includes/functions.php');


$idea_id = (int)($_GET['idea_id'])??0;


$get_idea = "SELECT * FROM ideas WHERE idea_id=$idea_id";
$result_idea = mysqli_query($link, $get_idea) or die(mysqli_error($link));
$idea = mysqli_fetch_assoc($result_idea);
echo json_encode($idea);