<?php
require_once('../../src/helpers.php');

header('Content-type: application/json; charset=utf-8');

if(!isset($_SESSION) || !isset($_SESSION["uid"])) {
    writeError(401, 'Unauthorized', "Ak chces pokracovat prihlas sa!");
    return;
}

$conn = new mysqli($hostname, $username, $password, $dbname);
$conn->set_charset("utf8");

$uid = $_SESSION["uid"];
$where = "WHERE st.ais_id=$uid";

if ($_SESSION["username"] == 'admin' && $uid == "999999999") {
    if(!isset($_GET["subject"])) {
        writeError(400, 'Bad Request', "Predmet musi byt zadany");
        return;
    }
    $subject = $_GET["subject"];

    if (!is_numeric($subject)) {
        writeError(400, 'Bad Request', "Predmet je v nespravnom tvar: $subject");
        return;
    }

    $where = "WHERE ss.subject_id=$subject";
}

$query = "SELECT st.ais_id, st.name, concat(su.label, ' - ',su.year) as subject, ss.id as subject_student_id 
          FROM student_subject as ss 
          JOIN student as st on st.ais_id = ss.student_id 
          JOIN subject as su on su.id = ss.subject_id $where";

$result = $conn->query($query);

if ($conn->error) {
    writeError(400, 'Bad Request', "Chyba pri ziskavani vysledkov studenta . Warning: $conn->error");
    return;
}
$temp = $result->fetch_all(MYSQLI_ASSOC);
$ret = array();

foreach ($temp as $item) {
    $ssid = $item['subject_student_id'];
    $query = "SELECT label, result FROM result WHERE student_subject_id = $ssid";
    $result = $conn->query($query);

    if ($conn->error) {
        writeError(400, 'Bad Request', "Chyba pri ziskavani vysledkov studenta . Warning: $conn->error");
        continue;
    }
    $item["resutlts"] = $result->fetch_all(MYSQLI_ASSOC);
    array_push($ret, $item);
}

$conn->close();
echo json_encode($ret);
