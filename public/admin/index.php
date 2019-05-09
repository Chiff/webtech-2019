<?php
require_once('../../src/helpers.php');
?>
<!DOCTYPE html>
<head>
    <title>Import testss</title>
    <?php writeHead() ?>
</head>
<body>
<nav>
    <a href="../">Uvod</a>
</nav>
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
    <input type="hidden" value="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"
           name="redirect"/>
    <input type="submit" name="addSub"/>

    <?php if (isset($_GET['form']) && $_GET['form'] == 'addSub')
        echo "<div class=\"form-message " . $_GET['type'] . "\">" . $_GET['message'] . "</div>";
    ?>
</form>
</body>
