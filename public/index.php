<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../src/Controller/csv-controller.php');

if (isset($_POST["submit"]) && isset($_FILES["file"])) {
    $foo = new CsvController();
    $foo->autoPilot($_POST["delimiter"], true);
}

?>
<!DOCTYPE html>
<head>
    <title>Zadanie</title>

    <link rel="stylesheet" type="text/css" href="http://147.175.121.210:8153/z2/style.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="../assets/js/main.js"></script>
</head>
<body>
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
    <label>
        Vyber CSV na import
        <input type="file" name="file" required>
    </label>
    <label>
        Delimiter
        <input type="text" name="delimiter" value=";" required>
    </label>
    <input type="submit" name="submit"/>
</form>
</body>
