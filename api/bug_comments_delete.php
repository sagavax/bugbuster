<?php

include "../includes/dbconnect.php";
include "../includes/functions.php";

$data = json_decode(file_get_contents('php://input'), true);

//echo json_encode($data); // debug

$comment_id = (int)($data['comment_id']);

$remove_comment = "DELETE FROM bugs_comments WHERE comm_id=$comment_id";
$result = mysqli_query($link, $remove_comment) or die(json_encode(['error' => 'Database error: ' . mysqli_error($link)]));

echo json_encode(['result' => 'success']);