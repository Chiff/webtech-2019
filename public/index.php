<?php
require_once('../src/helpers.php');
require_once('../src/csv/results-importer.php');

if (isset($_POST["results"]) && isset($_FILES["file"])) {
    $results = new ResultsImporter();
    $results->autoPilot($_POST["delimiter"], true);
}
//temporary....................
//session_start();
//if (!isset($_SESSION['username'])) {
//    $_SESSION['msg'] = "You must log in first";
//    header('location: login/index.php');
//} else if (isset($_POST['log_out'])) {
//    session_destroy();
//    unset($_SESSION['username']);
//    header("location: login/index.php");
//}
// end temporary....................
?>
<!DOCTYPE html>
<head>
    <title>Import test</title>
    <?php include('head.php'); ?>
</head>
<body>
<?php include('nav.php'); ?>
<div id = "tmpDvv">
    <!--netrebalo by if-->
    <h1>Welcome <?php if (isset($_SESSION["username"])) echo $_SESSION["username"];  ?></h1>
    <h2>Log in through <?php if (isset($_SESSION["login"])) echo $_SESSION["login"];  ?></h2>

    <form action="index.php" method="post">
        <button type="submit" name="log_out">
            Odhlásiť sa
        </button>
    </form>
</div>
<h2>Admin import bodov</h2>
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
    <label>
        Vyber CSV na import
        <input type="file" name="file" required>
    </label>
    <label>
        Delimiter
        <input type="text" name="delimiter" value=";" required>
    </label>
    <input type="submit" name="results"/>
</form>
<div class="response-message">
    <?php if (isset($results)) echo $results->getMessage(); ?>
</div>
</body>
