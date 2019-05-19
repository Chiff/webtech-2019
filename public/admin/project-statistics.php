<?php
require_once('../../src/helpers.php');

if (!isset($_SESSION) || !isset($_SESSION["uid"]) || $_SESSION["username"] != 'admin' || $_SESSION["uid"] != "999999999") {
    header('location:'. $baseFolder. '/public/login/index.php');
}

// Create connection
$conn = new mysqli($hostname, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8");
$sql = "SELECT * FROM `project` WHERE 1";

$result = $conn->query($sql);

$data = [];
if (0 < $result->num_rows) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

?>
    <!DOCTYPE html>
    <html lang="sk">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="google-site-verification" content="MSF8nltigNlCWnsp5OzxANLiQrnyKkkAKl-DhoW6GuU"/>
        <title data-translate>Štatistiky projektov</title>
        <?php include('../head.php'); ?>
        <!-- data tables-->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
        <!-- jQuery UI -->
        <link rel="stylesheet"
              href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        <!-- jQuery UI -->
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <!-- data tables-->
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

    </head>
    <body>
    <?php include('../nav.php'); ?>
    <br>
    <div class="mainContainer">
        <div class="d-flex justify-content-center">
            <table id="MailTable" class="table">
                <caption><h3 data-translate>Štatistiky projektov</h3></caption>
                <thead>
                <tr>
                    <th data-translate>Meno projektu</th>
                </tr>
                </thead>

                <tbody>
                <?php
                foreach ($data as $row) {
                    echo "<tr>",
                    "<td>", "<a class=\"btn btn-outline-primary\" href=\"eval-stats.php?project=" . $row["id"] . "\">" . $row["label"] . "</a>", "</td>",
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
