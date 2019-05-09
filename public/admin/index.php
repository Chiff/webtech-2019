<?php
require_once('../../src/helpers.php');
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
</body>
