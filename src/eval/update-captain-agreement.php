<?php
require_once('../../src/helpers.php');

$number = count($_POST["points"]);

$points = [];
if ($number > 0) {
    for ($i = 0; $i < $number; $i++) {
        $points[] = $_POST["points"][$i];
    }

    // Create connection
    $conn = new mysqli($hostname, $username, $password, $dbname);
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $conn->set_charset("utf8");

    $sql = "UPDATE `teammate` SET `result`=? WHERE `teammate`.`student_id` = ? AND `teammate`.`team_id` = ?";
    $get_sid_sql = "SELECT `student_id` FROM `teammate` WHERE team_id = ?";

    $tid = $conn->escape_string($_POST['team']);

    $get_stmt = $conn->prepare($get_sid_sql);
    $post_stmt = $conn->prepare($sql);


    $get_stmt->bind_param("s", $tid);
    $get_stmt->execute();
    $result = $get_stmt->get_result();

    $student_ids = [];
    if (0 < $result->num_rows) {
        while ($row = $result->fetch_assoc()) {
            $student_ids[] = $row["student_id"];
        }
    }
    for ($i = 0; $i < $number; $i++) {
        $post_stmt->bind_param("sss", $points[$i], $student_ids[$i], $tid);
        $post_stmt->execute();
    }
    echo "Data Inserted";
} else {
    echo "Please Enter Name";
}

