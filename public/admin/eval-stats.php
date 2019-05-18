<?php
require_once('../../src/helpers.php');

if (!isset($_SESSION) || !isset($_SESSION["uid"]) || $_SESSION["username"] != 'admin' || $_SESSION["uid"] != "999999999") {
    writeError(401, 'Unauthorized', "Ak chces pokracovat prihlas sa!");
    return;
}

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

$projectID = 24;
if (isset($_GET['project']))
    $projectID = $_GET['project'];

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
        <br>

        <div class="row">
            <div class="col-6">
                <h3>Študenti</h3>
                <br>

                <table id="studentTable" class="table">
                    <thead>
                    <tr>
                        <th>Počet študentov v predmete</th>
                        <th>Počet súhlasiacich študentov</th>
                        <th>počet nesúhlasiacich študentov</th>
                        <th>počet študentov, ktorí sa nevyjadrili</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <br>

                <div>
                    <canvas id="studentChart"></canvas>
                </div>
            </div>

            <div class="col-6">
                <h3>Tímy</h3>
                <br>

                <table id="teamTable" class="table">
                    <thead>
                    <tr>
                        <th>Počet tímov</th>
                        <th>Počet uzavretých tímov</th>
                        <th>Počet tímov, ku ktorým sa treba vyjadriť</th>
                        <th>počet tímov s nevyjadrenými študentami</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <br>
                <div>
                    <canvas id="teamChart"></canvas>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <button onclick="downloadStats()">Download</button>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js"></script>
    <script src="update-stats-data.js"></script>
    <script>
        $(document).ready(function () {
            updateTeamData(<?php echo $projectID;?>);
        });

    </script>
    </body>
    </html>
<?php
