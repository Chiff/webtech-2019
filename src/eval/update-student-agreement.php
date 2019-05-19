<?php

require_once('../../src/helpers.php');

// Create connection
$conn = new mysqli($hostname, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8");
$sql = "UPDATE `teammate` SET `agree` = ? WHERE `teammate`.`student_id` = ? AND `teammate`.`team_id` = ?";

$stmt = $conn->prepare($sql);
$agree = $conn->escape_string($_POST['agree']);
$tid = $conn->escape_string($_POST['team']);
$uid = $conn->escape_string($_SESSION["uid"]);
$stmt->bind_param("sss", $agree, $uid, $tid);
$stmt->execute();
echo $agree, "<br>", $tid, "<br>", $uid;