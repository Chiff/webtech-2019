<?php
require_once('../src/helpers.php');

if(isset($_GET['subjectToDelete'])){
    echo 'number: '. $_GET['subjectToDelete'];
    $conn = new mysqli($hostname, $username, $password, $dbname);
    $conn->set_charset("utf8");
    if ($conn->connect_error) {
//        die("Connection failed: " . $conn->connect_error);
        echo 'erroooooooooooooooooor';
    } else
        echo 'doooooooooooooobre';
    $query = 'DELETE FROM subject WHERE id =' .$_GET['subjectToDelete'];
    $result = $conn->query($query);
}

?>
<!DOCTYPE html>
<head>
    <title>Import test</title>
    <?php include('head.php'); ?>
    <?php echo "<script src='comboBoxForResult.js' type='module'></script>"; // lebo php ¯\_(ツ)_/¯ ?>
</head>

<body>
<?php include('nav.php'); ?>
<script type="text/javascript" src="result.js"></script>

<div class="page-wrapper">
    <h1>Welcome <?php echo $_SESSION["username"]; ?></h1>
    <h2>Log in through <?php echo $_SESSION["login"]; ?></h2>
    <h3>uid = <?php echo $_SESSION["uid"] ?></h3>
<!--    <h5>--><?php //echo $_SESSION["foo"]?><!--</h5>-->
    <span data-translate>Ahoj <span>neprekladaj</span> preloz</span>
</div>

<!--pre admina-->
<?php if ($_SESSION['username'] == 'admin') {
 echo '
<div class = "page-wrapper">
<form action="index.php" method="post" id="chooseSubject">
    <div class="form-group combo-wrapper async">
        <label for="subject" class="combo">Predmet</label>
        <input type="text" id="subject" class="form-control combo" name="subject" required autocomplete="off">
        <ul class="jumbotron" style="display: none;" id="subject-list">
            <li data-disabled="true">Udaje sa načítavajú</li>
        </ul>
    </div>
        <button type="submit" class="btn btn-primary" name="chooseSubject">Zobraziť</button>
        <button id="deleteButton" type="submit" class="btn btn-primary" name="chooseSubject" hidden="true">Vymazať</button>
</form>
</div>';

// echo '
//<div class = "page-wrapper">
//<form method="post" id="selectTeam">
//    <div class="form-group combo-wrapper async">
//        <label for="subject" class="combo">Predmet</label>
//        <input type="text" id="subject" class="form-control combo" name="subject" required autocomplete="off">
//        <ul class="jumbotron" style="display: none;" id="team-list">
//            <li data-disabled="true">Udaje sa načítavajú</li>
//        </ul>
//    </div>
//    <button type="submit" class="btn btn-primary" name="chooseSubject">Zobraziť</button>
//</form>
//</div>';
}
?>



<br>
<div id='tables' class="printableTable page-wrapper"></div>
<div class="page-wrapper">
    <button class="btn btn-primary page-wrapper" onclick="printDiv()">Print</button>
    <iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>
</div>

<script type="text/javascript" src="result.js"></script>
<script>
    let login = '<?php echo $_SESSION["username"]?>';
    // console.log(idSubject);
   if(login !== "admin"){
       printTables(login, 1)
   }
</script>

</body>
