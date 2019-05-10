<?php
require_once('../../src/helpers.php');


// TODO - 09.05.2019 - as rest API

$conn = new mysqli($hostname, $username, $password, $dbname);
$conn->set_charset("utf8");
if (isset($_POST['addSub'])) {
    if (isset($_POST['year']) && isset($_POST['subject'])) {
        $year = $conn->escape_string($_POST['year']);
        $subject = $conn->escape_string($_POST['subject']);

        if (preg_match("/^20[0-9]{2}\/20[0-9]{2}$/U", $year) == false) {
            header("Location: index.php?form=addSub&type=error&message=" . urlencode('Zadany format roku je nespravny'));
            return;
        }

        $query = "INSERT INTO `subject` (`label`, `year`) VALUES ('" . $subject . "','" . $year . "')";
        $result = $conn->query($query);

        if (!$result) {
            header("Location: index.php?form=addSub&type=error&message=" . urlencode($conn->error));
            return;
        }

        $conn->close();

        header("Location: index.php?form=addSub&type=success&message=" . urlencode('Operacia uspesna!'));
        return;
    }
}
