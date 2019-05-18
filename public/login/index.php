<?php
	session_start();
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
	<h1 class="h3 mb-3 font-weight-normal" data-translate>Prosím prihláste sa</h1>
	<label for="inputUsername" class="mt-3 mb-0">Login / IS</label>
	<input type="text" class="form-control" id="inputUsername" name="username" required="" autofocus="">
	<label for="inputPassword" class="mt-3 mb-0"><span data-translate>Heslo</span></label>
	<input type="password" class="form-control" id="inputPassword" name="password" required="">
	<button class="btn btn-lg btn-primary btn-block" type="submit" name="login_user"><span data-translate>Prihlásiť sa</span></button>
    <div class="mt-2" style="color: red">
        <?php
        if (isset($_SESSION["login_message"])) {
            echo $_SESSION["login_message"];
        }
        ?>
    </div>
</form>
</body>
