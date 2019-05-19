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
    <title data-translate>Uvod</title>
    <?php include('head.php'); ?>
    <?php echo "<script src='comboBoxForResult.js' type='module'></script>"; // lebo php ¯\_(ツ)_/¯ ?>
</head>

<body>
<?php include('nav.php'); ?>
<script type="text/javascript" src="result.js"></script>

<!--pre admina-->
<?php if ($_SESSION['username'] == 'admin') {
 echo '
<div class = "page-wrapper">
<form action="index.php" method="post" id="chooseSubject">
    <div class="form-group combo-wrapper async">
        <label for="subject" class="combo" data-translate>Predmet</label>
        <input type="text" id="subject" class="form-control combo" name="subject" required autocomplete="off">
        <ul class="jumbotron" style="display: none;" id="subject-list">
            <li data-disabled="true" data-translate>Udaje sa načítavajú</li>
        </ul>
    </div>  
    <p id="responseMessage"></p>
        <button type="submit" class="btn btn-primary" name="chooseSubject" data-translate>Zobraziť</button>
        <button id="deleteButton" type="submit" class="btn btn-primary" name="chooseSubject" hidden="true" data-translate>Vymazať</button>
</form>
</div>';
}
?>

<div id='tables' class="page-wrapper" hidden></div>
<div id='printButton' class="page-wrapper" hidden>
    <button  class="btn btn-primary page-wrapper" onclick="printDiv('tables')" data-translate>Tlačiť</button>
<!--    <button id='printButton2' class="btn btn-primary page-wrapper" onclick="printAll()" hidden="true">Print All</button>-->
    <iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>
</div>

<script>
    let login = '<?php echo $_SESSION["username"]?>';
   if(login !== "admin"){
       printSubjectTables(login, 1)
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

<?php if ($_SESSION['username'] == 'admin') {?>
<div class = "page-wrapper">
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data"
          id="chooseProject">
        <div class="form-group combo-wrapper async">
            <label for="subject-import" class="combo"><span data-translate>Vyber</span> <span
                        data-translate>predmet</span></label>
            <input type="text" class="form-control combo" id="subject-import" name="subject" required
                   autocomplete="off">
            <ul class="jumbotron" style="display: none;" id="subject-list-import">
                <li data-disabled="true" data-translate>Udaje sa načítavajú</li>
            </ul>
        </div>

        <div class="form-group combo-wrapper async">
            <label for="project-import" class="combo"><span data-translate>Vyber</span> <span
                        data-translate>projekt</span></label>
            <input type="text" class="form-control combo" id="project-import" name="project" required
                   autocomplete="off"
                   disabled>
            <ul class="jumbotron" style="display: none;" id="project-list-import">
                <li data-disabled="true" data-translate>Udaje sa načítavajú</li>
            </ul>
        </div>
        <div class="response-message">
            <?php if (isset($users)) {
                echo $users->getMessage();
            } ?>
        </div>
	    <p id="responseMessagae-proj"></p>
        <button type="submit" name="users" class="btn btn-primary" data-translate>Zobraziť</button>
	    <button id="deleteButton-proj" type="submit" class="btn btn-primary" name="chooseSubject" hidden="true" data-translate>Vymazať</button>
    </form>

	<div id="tables-proj" hidden></div>

	<div id='printButton-proj' hidden>
			<button  class="btn btn-primary page-wrapper" onclick="printDiv('tables-proj')" data-translate>Tlačiť</button>
			<!--    <button id='printButton2' class="btn btn-primary page-wrapper" onclick="printAll()" hidden="true">Print All</button>-->
			<iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>
		</div>

</div>
<?php } ?>
</body>
