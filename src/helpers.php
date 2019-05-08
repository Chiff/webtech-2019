<?php
require_once('../config/config.php');

if ($enableDebug) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

function writeHead() {
    echo '
    <link rel="stylesheet" type="text/css" href="http://147.175.121.210:8153/z2/style.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="../assets/js/main.js"></script>
    ';
}

function stringExists($str) {
    return (isset($str) && trim($str) !== '');
}
