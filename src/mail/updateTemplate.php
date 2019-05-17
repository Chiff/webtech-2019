<?php
require "../../config/config.php";

if (isset($_GET["template"])) {
    $conn = new mysqli($hostname, $username, $password, $dbname);
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $conn->set_charset("utf8");
    $sql = "SELECT * FROM sablona";

    $result = $conn->query($sql);

    $message_ids = [];
    $message_vals = [];
    if ($result->num_rows > 0) {
        // output data of each row
        $message = [];
        while ($row = $result->fetch_assoc()) {
            $message_ids[] = $row["id"];
            $message_vals[] = "Sablona " . $row["id"];
            $message[$row["id"]] = $row["oslovenie"] . "<br><br>" .
                $row["uvod"] . "<br><br>" .
                $row["verejnaIP"] . " ((ip))<br>" .
                $row["login"] . " ((login))<br>" .
                $row["heslo"] . " ((heslo))<br><br>" .
                $row["http"] . "((url)):((port))<br><br>" .
                $row["pozdrav"] . "<br><br>((sender))";
        }
    }

    echo $message[$_GET["template"]];
}