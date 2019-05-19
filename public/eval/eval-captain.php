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
        <form name="points_form" id="points_form">
            <input type="hidden" name="team" value="<?php echo $_GET['team_id'] ?>">
            <table id="teamTable" class="table">
                <caption data-translate><?php echo $_GET['project_name'] ?> Udelené
                    body: <?php echo $_GET['project_points'] ?> </caption>
                <thead>
                <th data-translate>Meno a priezvisko</th>
                <th data-translate>Pridelené body</th>
                <th></th>
                </thead>
                <tbody>

                </tbody>
            </table>
            <input type="button" name="submit" id="submit" class="btn btn-info" value="Submit"/>
        </form>
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
    let total_points = <?php
        if (isset($_GET['project_points']))
            echo $_GET['project_points'];
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
                        updateTeamCaptain(project.teammates);
                    }
                });
            },
            error: function (xhr) {
                console.log("something went terribly wrong, but I dunno what...")
            }
        });

        $('#submit').click(function () {
            if (isValid()) {
                $.ajax({
                    url: "../../src/eval/update-captain-agreement.php",
                    method: "POST",
                    data: $('#points_form').serialize(),
                    success: function (data) {
                        console.log(data);
                        window.location.href = "index.php"
                    }
                });
            } else {
                alert("Rozdel všetky body!");
            }
        });
    });
</script>
</body>
</html>
