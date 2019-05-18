<?php
require_once('../src/helpers.php');

if(isset($_POST['chooseSubject'])){
    echo 'coool';
}
if(isset($_GET['subjectToDelete'])){
    $conn = new mysqli($hostname, $username, $password, $dbname);
    $conn->set_charset("utf8");
    if ($conn->connect_error) {
//        die("Connection failed: " . $conn->connect_error);
    }
    $query = 'DELETE FROM subject WHERE id =' .$_GET['subjectToDelete'];
    $result = $conn->query($query);
    $responseMessage = 'Vymazanie bolo uspesne';
}

?>
<!DOCTYPE html>
<head>
    <title>Uvod</title>
    <?php include('head.php'); ?>
    <?php echo "<script src='comboBoxForResult.js' type='module'></script>"; // lebo php ¯\_(ツ)_/¯ ?>
</head>

<body>
<?php include('nav.php'); ?>
<script type="text/javascript" src="result.js"></script>

<!--pre admina-->
<?php if ($_SESSION['username'] == 'admin') {
 echo '
<div class = "page-wrapper printableTable">
<form action="index.php" method="post" id="chooseSubject">
    <div class="form-group combo-wrapper async">
        <label for="subject" class="combo">Predmet</label>
        <input type="text" id="subject" class="form-control combo" name="subject" required autocomplete="off">
        <ul class="jumbotron" style="display: none;" id="subject-list">
            <li data-disabled="true">Udaje sa načítavajú</li>
        </ul>
    </div>  
    <p id="responseMessage"></p>
        <button type="submit" class="btn btn-primary" name="chooseSubject">Zobraziť</button>
        <button id="deleteButton" type="submit" class="btn btn-primary" name="chooseSubject" hidden="true">Vymazať</button>
</form>
</div>';
}
?>

<div id='tables' class="printableTable page-wrapper"></div>
<div class="page-wrapper printableTable">
    <button id='printButton' class="btn btn-primary page-wrapper" onclick="printDiv()" hidden="true">Print</button>
    <button id='printButton2' class="btn btn-primary page-wrapper" onclick="printAll()" hidden="true">Print All</button>
    <iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>
</div>

<script>
    let login = '<?php echo $_SESSION["username"]?>';
   if(login !== "admin"){
       printTables(login, 1)
   }
</script>

<?php
if(isset($responseMessage) && $responseMessage != '') {
    echo '<script>        
            $(\'#responseMessage\').text(\'Predmet bol vymazany\');
            $(\'#responseMessage\').addClass(\'alert alert-dismissible alert-success\');
          </script>';
}

?>
</body>
