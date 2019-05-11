<?php
require_once('../../src/helpers.php');

header('Content-type: application/json; charset=utf-8');

$conn = new mysqli($hostname, $username, $password, $dbname);
$conn->set_charset("utf8");

$uid = $_SESSION["uid"];
$query = "SELECT st.ais_id, st.name, concat(su.label, ' - ',su.year) as subject, ss.id as subject_student_id 
          FROM student_subject as ss 
          JOIN student as st on st.ais_id = ss.student_id 
          JOIN subject as su on su.id = ss.subject_id
          WHERE st.ais_id=$uid;
";
$result = $conn->query($query);

if ($conn->error) {
    writeError(400, 'Bad Request', "Chyba pri ziskavani vysledkov studenta. Warning: $conn->error");
    return;
}
$temp = $result->fetch_all(MYSQLI_ASSOC);
$ret = array();

foreach ($temp as $item) {
    $ssid = $item['subject_student_id'];
    $query = "SELECT label, result FROM result WHERE student_subject_id=$ssid";
    $result = $conn->query($query);

    if ($conn->error) {
        writeError(400, 'Bad Request', "Chyba pri ziskavani vysledkov studenta. Warning: $conn->error");
        continue;
    }
    $item["resutlts"] = $result->fetch_all(MYSQLI_ASSOC);
    array_push($ret, $item);
}

$conn->close();
echo json_encode($ret);
