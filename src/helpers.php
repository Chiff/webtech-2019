<?php
require_once('../config/config.php');

session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: ../public/login/index.php');
} else if (isset($_POST['log_out'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: ../public/login/index.php");
}

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
