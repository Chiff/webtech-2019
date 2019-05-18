<?php
require_once('../../src/helpers.php');

header('Content-type: application/json; charset=utf-8');

if (!isset($_SESSION) || !isset($_SESSION["uid"])) {
    writeError(401, 'Unauthorized', "Ak chces pokracovat prihlas sa!");
    return;
}

$conn = new mysqli($hostname, $username, $password, $dbname);
$conn->set_charset("utf8");

$uid = $_SESSION["uid"];
$query = "SELECT team_id FROM `teammate`WHERE student_id=$uid";

$result = $conn->query($query);
if ($conn->error) {
    writeError(400, 'Bad Request', "Chyba pri ziskavani timov pre studenta $uid . Warning: $conn->error");
    return;
}

$teams = $result->fetch_all(MYSQLI_ASSOC);

$final = array();
foreach ($teams as $oneTeam) {
    $team = $oneTeam['team_id'];

    $query = "SELECT * FROM `team` WHERE id=$team";

    $result = $conn->query($query);
    if ($conn->error) {
        writeError(400, 'Bad Request', "Chyba pri ziskavani timu: $team. Warning: $conn->error");
        return;
    }

    $temp = $result->fetch_all(MYSQLI_ASSOC);

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
        $teammates = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($teammates as $teammate => $value) {
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
        $ret = $item;
    }

    array_push($final, $ret);
}

$conn->close();
echo json_encode($final);
