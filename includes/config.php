<?php
// Určenie protokolu (http alebo https)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";

// Názov domény
$host = $_SERVER['HTTP_HOST'];

// Koreňová cesta (bez /includes napr.)
$root = dirname(__DIR__);
define('BASE_URL', $protocol . $host."bugbuster/");

echo BASE_URL;

?>
