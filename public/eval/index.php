<?php
require_once('../../src/helpers.php');

?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="MSF8nltigNlCWnsp5OzxANLiQrnyKkkAKl-DhoW6GuU"/>
    <title>Evaluácia</title>
    <?php include('../head.php'); ?>

</head>
<body>
<?php include('../nav.php'); ?>
<br>
<div class="mainContainer">
    <div class="d-flex justify-content-center">
        <table id="projectTable" class="table" style="width: 75%">
            <thead>
            <th>Meno projektu</th>
            <th></th>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

</div>

<script>
    let uid = <?php
        if (isset($_SESSION['uid']))
            echo $_SESSION['uid'];
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
                updateTable(response);
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
