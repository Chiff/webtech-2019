<?php
require_once('../../config/config.php');


header("Content-Type: application/json; charset=UTF-8");
$conn = new mysqli($hostname, $username, $password, $dbname);
$conn->set_charset("utf8");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_GET['table']) && $_GET['table'] == 'subject') {
    $query = "SELECT id,  concat(label, ' - ', year) as name  FROM subject ORDER BY year DESC;";

    $result = $conn->query($query);
    $res = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc())
            $res[] = $row;
        $conn->close();

        echo json_encode($res);
    } else
        echo "0 results";

    $conn->close();
}

if (isset($_GET['table']) && isset($_GET['subject']) && $_GET['table'] == 'project') {
    $subjectID = $_GET['subject'];

    if (!is_numeric($subjectID)) {
        echo "0 results";
        $conn->close();
        return;
    }

    $query = "SELECT id, label as name  FROM project WHERE subject_id=$subjectID;";

    $result = $conn->query($query);
    $res = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc())
            $res[] = $row;
        $conn->close();

        echo json_encode($res);
    } else
        echo "0 results";

    $conn->close();
}


