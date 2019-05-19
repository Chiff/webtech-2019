<?php
require_once('../../src/helpers.php');

?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="MSF8nltigNlCWnsp5OzxANLiQrnyKkkAKl-DhoW6GuU"/>
    <title data-translate>Evaluácia</title>
    <?php include('../head.php'); ?>

</head>
<body>
<?php include('../nav.php'); ?>
<br>
<div class="mainContainer">
    <div class="d-flex justify-content-center">
        <table id="teamTable" class="table" style="width: 75%">
            <caption data-translate><?php echo $_GET['project_name'] ?> Udelené body: <?php echo $_GET['project_points'] ?> </caption>
            <thead>
            <th data-translate>Meno a priezvisko</th>
            <th data-translate>Pridelené body</th>
            <th></th>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="agreeModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" data-translate>Súhlas s rozdelením bodov</h4>
            </div>
            <div class="modal-body">
                <p data-translate>Naozaj súhlasíte s rozdelením bodov?<br>Rozhodnutie po odsúhlasení bude nemenné.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">zrušiť</button>
                <button type="button" class="btn btn-default" onclick="agreeResult(1,<?php echo $_GET['team_id']; ?>)"
                        data-dismiss="modal" data-translate>Pokračovať
                </button>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="disagreeModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" data-translate>Nesúhlas s rozdelením bodov</h4>
            </div>
            <div class="modal-body">
                <p data-translate>Naozaj nesúhlasíte s rozdelením bodov?<br>Rozhodnutie po neodsúhlasení bude nemenné.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" data-translate>zrušiť</button>
                <button type="button" class="btn btn-default" onclick="agreeResult(0,<?php echo $_GET['team_id']; ?>)"
                        data-dismiss="modal"data-translate>Pokračovať
                </button>
            </div>
        </div>

    </div>
</div>

<script>
    let uid = <?php
        if (isset($_SESSION['uid']))
            echo $_SESSION['uid'];
        else echo null;
        ?>;
    let pid = <?php
        if (isset($_GET['project_id']))
            echo $_GET['project_id'];
        else echo null;
        ?>;
</script>
<script src="eval.js"></script>
<script>
    $(document).ready(function () {
        $.ajax({
            url: "../api/projects.php",
            type: "get",
            data: {},
            success: function (response) {
                $.each(response, function (index, project) {
                    if (project.project_id == pid) {
                        updateTeam(project.teammates);
                    }
                });
            },
            error: function (xhr) {
                console.log("something went terribly wrong, but I dunno what...")
            }
        });

        console.log("UID: " + uid);
    });
</script>
</body>
</html>
