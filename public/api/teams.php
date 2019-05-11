<?php
require_once('../../src/helpers.php');

header('Content-type: application/json; charset=utf-8');

if (!isset($_SESSION) || !isset($_SESSION["uid"]) || $_SESSION["username"] != 'admin' || $_SESSION["uid"] != "999999999") {
    writeError(401, 'Unauthorized', "Ak chces pokracovat prihlas sa!");
    return;
}

$conn = new mysqli($hostname, $username, $password, $dbname);
$conn->set_charset("utf8");

$uid = $_SESSION["uid"];

if (!isset($_GET["project"])) {
    writeError(400, 'Bad Request', "Projekt musi byt zadany");
    return;
}

$project = $_GET["project"];

if (!is_numeric($project)) {
    writeError(400, 'Bad Request', "Projekt je v nespravnom tvare: $project");
    return;
}

$query = "SELECT * FROM `team` WHERE project_id=$project";
$result = $conn->query($query);

if ($conn->error) {
    writeError(400, 'Bad Request', "Chyba pri ziskavani timov pre projekt $project . Warning: $conn->error");
    return;
}

$temp = $result->fetch_all(MYSQLI_ASSOC);
$ret = array();

foreach ($temp as $item) {
    $team_id = $item['id'];
    $team_number = $item['team_number'];
    $query = "SELECT student_id, result, agree FROM teammate WHERE team_id=$team_id";
    $result = $conn->query($query);

    if ($conn->error) {
        writeError(400, 'Bad Request', "Chyba pri ziskavani studentov pre tim cislo: $team_number, id: $team_id. Warning: $conn->error");
        continue;
    }

    $item["teammates"] = array();
    $x = $result->fetch_all(MYSQLI_ASSOC);
    foreach ($x as $teammate => $value) {
        $teammate_id = $value["student_id"];
        $query = "SELECT email, name FROM student WHERE ais_id=$teammate_id";
        $result = $conn->query($query);

        if ($conn->error) {
            writeError(400, 'Bad Request', "Chyba pri ziskavani udajov o studentovi. Warning: $conn->error");
            continue;
        }
        $value["student"] = $result->fetch_all(MYSQLI_ASSOC);
        array_push($item["teammates"], $value);
    }
    array_push($ret, $item);
}

$conn->close();
echo json_encode($ret);
