<?php


  global $link;

  include "../includes/dbconnect.php";
    include "../includes/functions.php";

  
    //create tag in Tagsphere

    $app_name = "bugbuster";
    $tag_name = mysqli_real_escape_string($link, $_POST['tag_name']);
    
    
    // Údaje pre nové issue
    $data = [
        "tag_application" => $app_name,
        "tag_name" => $tag_name,
    ];

    if($_SERVER['HTTP_HOST'] == "localhost"){
        $api_host = "localhost/tagsphere";
    } else {
        $api_host = "https://tagsphere.tmisura.sk";
    }
    

    // Inicializácia cURL
    $ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_URL, $api_host . "/api/api.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Spustenie požiadavky a spracovanie odpovede
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Spracovanie chýb
    if (curl_errno($ch)) {
        $error = curl_error($ch);
        return ["success" => false, "error" => $error];
    }

    // Návrat celej odpovede spolu s HTTP kódom
    return [
        "success" => $httpCode === 201,
        "http_code" => $httpCode,
        "response" => json_decode($response, true)
    ];