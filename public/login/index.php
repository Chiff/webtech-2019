<?php
	session_start();
	if (isset($_SESSION["login_message"])) {
		echo $_SESSION["login_message"];
	}

	if (isset($_SESSION['username'])) {
		$_SESSION['msg'] = "You are log in already";
		header('location: ../index.php');
	}
?>

<!DOCTYPE html>
<head>
	<title>Import test</title>
	<?php include('../head.php'); ?>
</head>
<body>
<form class="form-signin" action="../../src/login-manager.php" method="post">
	<h1 class="h3 mb-3 font-weight-normal">Prosím prihláste sa</h1>
	<label for="inputUsername" class="mt-3 mb-0">Meno</label>
	<input type="text" class="form-control" id="inputUsername" name="username" placeholder="Prihlasovacie meno / IS"
	       required="" autofocus="">
	<label for="inputPassword" class="mt-3 mb-0">Heslo</label>
	<input type="password" class="form-control" id="inputPassword" name="password" placeholder="Heslo" required="">
	<button class="btn btn-lg btn-primary btn-block" type="submit" name="login_user">Prihlásiť sa</button>
</form>
</body>
