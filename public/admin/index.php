<?php
require_once('../../src/helpers.php');
require_once('../../src/csv/user-importer.php');

if (isset($_POST["users"]) && isset($_POST["project"]) && isset($_FILES["file"])) {
    $users = new UserImporter();
    if ($users->autoPilot($_POST["delimiter"], true)) {
        $conn = new mysqli($hostname, $username, $password, $dbname);
        $conn->set_charset("utf8");

        $users->insert($_POST["project"], $conn);
    }
}
?>
<!DOCTYPE html>
<head>
    <title>Admin</title>
    <?php include('../head.php'); ?>
    <?php echo "<script src='admin.js' type='module'></script>"; // lebo php ¯\_(ツ)_/¯ ?>
</head>
<body>
<?php include('../nav.php'); ?>

<h2>Vytovernie noveho predmetu</h2>
<form action="add-subject.php" method="post" id="addSub">
    <label>
        Zadaj rocnik vo formate <code>20xx/20xx</code>
        <input type="text" name="year" pattern="^20[0-9]{2}\/20[0-9]{2}$" title="Format musi byt 20xx/20xx" required>
    </label>
    <label>
        Zadaj nazov predmetu
        <input type="text" name="subject" required>
    </label>
    <input type="submit" name="addSub"/>

    <?php if (isset($_GET['form']) && $_GET['form'] == 'addSub')
        echo "<div class='form-message " . $_GET['type'] . "'>" . $_GET['message'] . "</div>";
    ?>
</form>

<h2>Vytovernie noveho projektu</h2>
<form action="add-project.php" method="post" id="addProject">
    <div class="combo-wrapper async">
        <label for="subject" class="combo">Zadaj nazov predmetu</label>
        <input type="text" class="combo" id="subject" name="subject" required autocomplete="off">
        <ul style="display: none;" id="subject-list">
            <li data-disabled="true">Udaje sa načítavajú</li>
        </ul>
    </div>
    <label>
        Zadaj nazov projektu
        <input type="text" name="project" required>
    </label>
    <input type="submit" name="addProject"/>

    <?php if (isset($_GET['form']) && $_GET['form'] == 'addProject')
        echo "<div class='form-message " . $_GET['type'] . "'>" . $_GET['message'] . "</div>";
    ?>
</form>

<h2>Import uzivatelov</h2>
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
    <div class="combo-wrapper async">
        <label for="subject-import" class="combo">Zadaj nazov predmetu</label>
        <input type="text" class="combo" id="subject-import" name="subject" required autocomplete="off">
        <ul style="display: none;" id="subject-list-import">
            <li data-disabled="true">Udaje sa načítavajú</li>
        </ul>
    </div>
    <div class="combo-wrapper async">
        <label for="project-import" class="combo">Zadaj nazov projektu</label>
        <input type="text" class="combo" id="project-import" name="project" required autocomplete="off" disabled>
        <ul style="display: none;" id="project-list-import">
            <li data-disabled="true">Udaje sa načítavajú</li>
        </ul>
    </div>
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
