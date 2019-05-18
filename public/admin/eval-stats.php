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

$studenOK = 2;
$studenNOK = 13;
$studenNOPE = 34;

$teamOK = 2;
$teamNOK = 13;
$teamNOPE = 34;

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
        <div class="row">
            <div class="col-6">
                <h3>Študenti</h3>
                <br>

                <table id="studentTable" class="table">
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
                <br>
                <div>
                    <canvas id="teamChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js"></script>
    <script>

        const ctx = document.getElementById("studentChart").getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ["Počet súhlasiacich študentov", "Počet nesúhlasiacich študentov", "Počet študentov, ktorí sa nevyjadrili"],
                datasets: [{
                    label: 'Počet študentov v predmete',
                    data: [
                        <?php echo $studenOK; ?>,
                        <?php echo $studenNOK; ?>,
                        <?php echo $studenNOPE; ?>
                    ],
                    backgroundColor: [
                        'rgba(0, 120,0, 0.3)',
                        'rgba(120, 0, 0, 0.3)',
                        'rgba(0, 0, 120, 0.3)'
                    ],
                    borderColor: [
                        'rgba(0, 120,0, 1)',
                        'rgba(120, 0, 0, 1)',
                        'rgba(0, 0, 120, 1)'
                    ],
                    borderWidth: 2
                }]
            }
        });

        const ctx2 = document.getElementById("teamChart").getContext('2d');
        const myChart2 = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ["Počet súhlasiacich študentov", "Počet nesúhlasiacich študentov", "Počet študentov, ktorí sa nevyjadrili"],
                datasets: [{
                    label: 'Počet študentov v predmete',
                    data: [
                        <?php echo $teamOK; ?>,
                        <?php echo $teamNOK; ?>,
                        <?php echo $teamNOPE; ?>
                    ],
                    backgroundColor: [
                        'rgba(0, 120,0, 0.3)',
                        'rgba(120, 0, 0, 0.3)',
                        'rgba(0, 0, 120, 0.3)'
                    ],
                    borderColor: [
                        'rgba(0, 120,0, 1)',
                        'rgba(120, 0, 0, 1)',
                        'rgba(0, 0, 120, 1)'
                    ],
                    borderWidth: 2
                }]
            }
        });

    </script>
    </body>
    </html>
<?php
