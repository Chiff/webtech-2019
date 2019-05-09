<?php
require_once('../src/helpers.php');
require_once('../src/csv/results-importer.php');
require_once('../src/csv/user-importer.php');

if (isset($_POST["results"]) && isset($_FILES["file"])) {
    $results = new ResultsImporter();
    $results->autoPilot($_POST["delimiter"], true);
}

if (isset($_POST["users"]) && isset($_FILES["file"])) {
    $users = new UserImporter();
    $users->autoPilot($_POST["delimiter"], true);
}

?>
<!DOCTYPE html>
<head>
    <title>Import test</title>
    <?php writeHead() ?>
</head>
<body>
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

<h2>Admin import uzivatelov</h2>
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
    <label>
        Vyber CSV na import
        <input type="file" name="file" required>
    </label>
    <label>
        Delimiter
        <input type="text" name="delimiter" value=";" required>
    </label>
    <input type="submit" name="users"/>
</form>
<div class="response-message">
    <?php if (isset($users)) echo $users->getMessage(); ?>
</div>
</body>
