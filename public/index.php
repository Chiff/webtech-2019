<?php
require_once('../src/helpers.php');

?>
<!DOCTYPE html>
<head>
    <title>Import test</title>
    <?php include('head.php'); ?>
    <?php echo "<script src='comboBoxForResult.js' type='module'></script>"; // lebo php ¯\_(ツ)_/¯ ?>

</head>

<body>
<?php include('nav.php'); ?>

<div class="page-wrapper">
    <h1>Welcome <?php echo $_SESSION["username"]; ?></h1>
    <h2>Log in through <?php echo $_SESSION["login"]; ?></h2>
    <h3>uid = <?php echo $_SESSION["uid"] ?></h3>
<!--    <h5>--><?php //echo $_SESSION["foo"]?><!--</h5>-->
    <span data-translate>Ahoj <span>neprekladaj</span> preloz</span>
</div>


<form action="" method="post" id="chooseSubject">
    <div class="form-group combo-wrapper async">
        <label for="subject" class="combo">Predmet</label>
        <input type="text" id="subject" class="form-control combo" name="subject" required autocomplete="off">
        <ul class="jumbotron" style="display: none;" id="subject-list">
            <li data-disabled="true">Udaje sa načítavajú</li>
        </ul>
    </div>
    <button type="submit" class="btn btn-primary" name="chooseSubject">Submit</button>
</form>

<!--pre admina-->

<br>
<div id='tables' class="printableTable"></div>
<button class="btn btn-primary" onclick="printDiv()">Print</button>
<iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>
<script type="text/javascript" src="result.js"></script>
<script>
    let login = '<?php echo $_SESSION["username"]?>';
    printTables(login, 1);
</script>
</body>
