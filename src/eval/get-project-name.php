<?php
require_once('../../src/helpers.php');

// Create connection
$conn = new mysqli($hostname, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8");
$sql = "SELECT `label` FROM `project` WHERE id=?";

$stmt = $conn->prepare($sql);
$pid = $conn->escape_string($_GET['project_id']);
$stmt->bind_param("s", $pid);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
if (0 < $result->num_rows) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo $data[0]['label'];