<?php
require_once('../../src/helpers.php');

// Create connection
$conn = new mysqli($hostname, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8");
$sql = "SELECT * FROM `mail_statistics`";

$result = $conn->query($sql);

$data = [];
if (0 < $result->num_rows) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

if (!isset($_SESSION) || !isset($_SESSION["uid"]) || $_SESSION["username"] != 'admin' || $_SESSION["uid"] != "999999999") {
    writeError(401, 'Unauthorized', "Ak chces pokracovat prihlas sa!");
    return;
}

?>
    <!DOCTYPE html>
    <html lang="sk">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="google-site-verification" content="MSF8nltigNlCWnsp5OzxANLiQrnyKkkAKl-DhoW6GuU"/>
        <title>Štatistiky odoslaných mailov</title>
        <?php include('../head.php'); ?>

    </head>
    <body>
    <?php include('../nav.php'); ?>
    <br>
    <div class="mainContainer">
        <div>
            <table id="MailTable">
                <caption><h3>Študenti</h3></caption>
                <thead>
                <tr>
                    <th>Študent</th>
                    <th>Dátum</th>
                    <th>Predmet</th>
                    <th>Šablóna</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($data as $row) {
                    echo "<tr>",
                    "<td>", $row["student_name"], "</td>",
                    "<td>", date('d/m/Y', strtotime($row["date"])), "</td>",
                    "<td>", $row["subject"], "</td>",
                    "<td>", $row["template_id"], "</td>",
                    "</tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    </body>
    </html>
<?php
