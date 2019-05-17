<?php
require_once('../../src/helpers.php');

$conn = new mysqli($hostname, $username, $password, $dbname);
$conn->set_charset("utf8");
if (isset($_POST['addProject'])) {
    if (isset($_POST['project']) && isset($_POST['subject'])) {
        $project = $conn->escape_string($_POST['project']);
        $subject = $conn->escape_string($_POST['subject']);

        $query = "INSERT INTO `project` (`label`, `subject_id`) VALUES ('" . $project . "','" . $subject . "')";
        $result = $conn->query($query);

        if (!$result) {
            writeError(400, 'Bad Request', $conn->error);
            return;
        }

        $conn->close();

        $response = [];
        $response["form"] = 'addProject';
        $response["type"] = 'alert-success';
        $response["message"] = 'Operacia uspesna!';
        echo json_encode($response);
        return;
    }
}

writeError(400, 'Bad Request', 'Zly format poziadavku');
