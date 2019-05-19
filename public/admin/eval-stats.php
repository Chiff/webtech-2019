<?php
require_once('../../src/helpers.php');

if (!isset($_SESSION) || !isset($_SESSION["uid"]) || $_SESSION["username"] != 'admin' || $_SESSION["uid"] != "999999999") {
    header('location:'. $baseFolder. '/public/login/index.php');
}

$projectID = 25;
if (isset($_GET['project']))
    $projectID = $_GET['project'];

?>
    <!DOCTYPE html>
    <html lang="sk">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="google-site-verification" content="MSF8nltigNlCWnsp5OzxANLiQrnyKkkAKl-DhoW6GuU"/>
        <title data-translate>Štatistika evaluácie</title>
        <?php include('../head.php'); ?>

    </head>
    <body>
    <?php include('../nav.php'); ?>
    <br>
    <div class="mainContainer">
        <br>

        <div class="row">
            <div class="col-6">
                <h3 data-translate>Študenti</h3>
                <br>

                <table id="studentTable" class="table">
                    <thead>
                    <tr>
                        <th data-translate>Počet študentov v predmete</th>
                        <th data-translate>Počet súhlasiacich študentov</th>
                        <th data-translate>Počet nesúhlasiacich študentov</th>
                        <th data-translate>Počet študentov, ktorí sa nevyjadrili</th>
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
                <h3 data-translate>Tímy</h3>
                <br>

                <table id="teamTable" class="table">
                    <thead>
                    <tr>
                        <th data-translate>Počet tímov</th>
                        <th data-translate>Počet uzavretých tímov</th>
                        <th data-translate>Počet tímov, ku ktorým sa treba vyjadriť</th>
                        <th data-translate>Počet tímov s nevyjadrenými študentami</th>
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
            <button onclick="downloadStats()" data-translate>Stiahni</button>
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
