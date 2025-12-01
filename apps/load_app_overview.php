<?php
    include "../includes/dbconnect.php";
    include "../includes/functions.php";

    $app_id = $_POST['app_id'];


    $itemsPerPage = 10;
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($current_page - 1) * $itemsPerPage;  
            
    $app_name = strtolower(getAppName($app_id));
    