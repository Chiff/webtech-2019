<?php
require_once(dirname(__DIR__, 1) . '/config/config.php');

if ($enableDebug) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

function writeHead() {
    $dir = dirname(__DIR__, 1);
    $baseFolder = "http://" . $_SERVER['HTTP_HOST'] . str_replace($_SERVER['DOCUMENT_ROOT'], "", $dir);

    echo "
    <link rel=\"stylesheet\" type=\"text/css\" href=\"http://147.175.121.210:8153/z2/style.css\">
    <link rel=\"stylesheet\" type=\"text/css\" href=\"" . $baseFolder . "/assets/css/main.css\">
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js\"></script>
    <script src=\"" . $baseFolder . "/assets/js/main.js\"></script>
    ";
}

function stringExists($str) {
    return (isset($str) && trim($str) !== '');
}
