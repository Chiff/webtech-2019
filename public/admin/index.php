<?php
	require_once('../../src/helpers.php');
	require_once('../../src/csv/user-importer.php');
	require_once('../../src/csv/results-importer.php');

    $baseFolder = "http://" . $_SERVER['HTTP_HOST'] . str_replace($_SERVER['DOCUMENT_ROOT'], "", dirname(__DIR__, 1));
//    echo $baseFolder;
    if ($_SESSION['username'] != 'admin' ) {
        $_SESSION['msg'] = "You are not admin";
        header('location: '.$baseFolder.  '/index.php');
    }

	if (isset($_POST["results"]) && isset($_POST["subject"]) && isset($_FILES["file"])) {
		$results = new ResultsImporter();
		if ($results->autoPilot($_POST["delimiter"], true)) {
			$conn = new mysqli($hostname, $username, $password, $dbname);
			$conn->set_charset("utf8");

			$results->insert($_POST["subject"], $conn);
		}
	}

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

<h2><span data-translate>Vytvorenie noveho</span> <span data-translate>predmetu</span></h2>
<form action="add-subject.php" method="post" id="addSub">
	<div class="form-group">
		<label for="year">Ročník</label>
		<input type="text" id="year" name="year" class="form-control" pattern="^20[0-9]{2}\/20[0-9]{2}$"
		       title="Format musi byt 20xx/20xx" required>
		<small id="emailHelp" class="form-text text-muted">Formát ročníku musí byť v tvare <code class="color-secondary">20xx/20xx</code>
		</small>
	</div>

	<div class="form-group">
		<label for="subject">Nový predmet</label>
		<input type="text" id="subject" class="form-control" name="subject" required>
	</div>
	<?php if (isset($_GET['form']) && $_GET['form'] == 'addSub') {
		echo "<div class='alert ".$_GET['type']."'>".$_GET['message']."</div>";
	}
	?>
	<button type="submit" class="btn btn-primary" name="addSub">Submit</button>
</form>

<h2><span data-translate>Vytvorenie noveho</span> <span data-translate>projektu</span></h2>
<form action="add-project.php" method="post" id="addProject">

	<div class="form-group combo-wrapper async">
		<label for="subject" class="combo">Vyber predmet</label>
		<input type="text" id="subject" class="form-control combo" name="subject" required autocomplete="off">
		<ul class="jumbotron" style="display: none;" id="subject-list">
			<li data-disabled="true">Udaje sa načítavajú</li>
		</ul>
	</div>

	<div class="form-group combo-wrapper async">
		<label for="project">Nový projekt</label>
		<input type="text" name="project" class="form-control" id="project" required>
	</div>
	<?php if (isset($_GET['form']) && $_GET['form'] == 'addProject') {
		echo "<div class='alert ".$_GET['type']."'>".$_GET['message']."</div>";
	}
	?>
	<button type="submit" class="btn btn-primary" name="addProject">Submit</button>
</form>

<h2>Import uzivatelov</h2>
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data" id="user-import">
	<div class="form-group combo-wrapper async">
		<label for="subject-import" class="combo">Vyber predmet</label>
		<input type="text" class="form-control combo" id="subject-import" name="subject" required autocomplete="off">
		<ul class="jumbotron" style="display: none;" id="subject-list-import">
			<li data-disabled="true">Udaje sa načítavajú</li>
		</ul>
	</div>

	<div class="form-group combo-wrapper async">
		<label for="project-import" class="combo">Vyber projekt</label>
		<input type="text" class="form-control combo" id="project-import" name="project" required autocomplete="off"
		       disabled>
		<ul class="jumbotron" style="display: none;" id="project-list-import">
			<li data-disabled="true">Udaje sa načítavajú</li>
		</ul>
	</div>
	<div class="form-group with-file">
		<label for="delimiter">Vstup</label>
		<div class="input-group">
			<div class="input-group-prepend">
				<label class="input-group-text" for="delimiter">Delimiter</label>
			</div>
			<input type="text" class="form-control" id="delimiter" name="delimiter" value=";" maxlength="1" minlength="1" required>
			<div style="flex-grow: 3" class="custom-file">
				<input type="file" name="file" class="custom-file-input" id="inputGroupFile02" required>
				<label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Vyber CSV
					na import</label>
			</div>
		</div>
	</div>

	<button type="submit" name="users" class="btn btn-primary">Submit</button>

</form>
<div class="response-message">
	<?php if (isset($users)) {
		echo $users->getMessage();
	} ?>
</div>

<h2>Import bodov</h2>
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data" id="result-import">
	<div class="form-group combo-wrapper async">
		<label for="subject-import-results" class="combo">Vyber predmet</label>
		<input type="text" class="form-control combo" id="subject-import-results" name="subject" required autocomplete="off">
		<ul class="jumbotron" style="display: none;" id="subject-list-import-results">
			<li data-disabled="true">Udaje sa načítavajú</li>
		</ul>
	</div>

	<div class="form-group with-file">
		<label for="delimiter">Vstup</label>
		<div class="input-group">
			<div class="input-group-prepend">
				<label class="input-group-text" for="delimiter">Delimiter</label>
			</div>
			<input type="text" class="form-control" id="delimiter" name="delimiter" value=";" maxlength="1" minlength="1" required>
			<div style="flex-grow: 3" class="custom-file">
				<input type="file" name="file" class="custom-file-input" id="inputGroupFile02" required>
				<label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Vyber CSV
					na import</label>
			</div>
		</div>
	</div>
	<?php if (isset($results)) {
		echo $results->getMessage();
	} ?>
	<button type="submit" name="results" class="btn btn-primary">Submit</button>
</form>
</body>
