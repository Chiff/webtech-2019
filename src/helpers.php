<?php
require_once(dirname(__DIR__, 1) . '/config/config.php');

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

function stringExists($str) {
    return (isset($str) && trim($str) !== '');
}

function writeError($code, $title, $detail = 'Detail not specified')
{
    $response = array();
    $response['error'] = array();
    $response['error']['code'] = $code;
    $response['error']['title'] = $title;
    $response['error']['detail'] = $detail;

    echo json_encode($response);
    http_response_code($code);
}
