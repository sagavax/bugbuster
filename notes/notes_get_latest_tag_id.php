<?php


    $currAddress = $_SERVER['SERVER_NAME'];
if($currAddress == 'localhost') {
    $api_host = "http://localhost/tagsphere";
} else {
    $api_host = "https://tagsphere.tmisura.sk";
}

$apiUrl = $api_host.'/api/api.php?action=get_latest_tag_id';

$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => $apiUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_HTTPGET => true,
]);

$response = curl_exec($ch);
$httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);

echo $response;