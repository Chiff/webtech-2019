<?php
session_start();
if(isset($_SESSION["login_message"])){
    echo $_SESSION["login_message"];
}

if (isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You are log in already";
    header('location: ../index.php');
}
?>

<!DOCTYPE html>
<html lang=sk>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zaver</title>
    <link rel="stylesheet" type="text/css" media="screen" href="style.css">

</head>
<body>

<div class="forum mainContainer">
    <form action="../../src/login-manager.php" method="post">
        <h2>Prihlásiť sa</h2>
        <div>
            <label for='username' id='labelID1'>Meno</label>
            <input type="text" name="username" placeholder="Prihlasovacie meno / IS" required="required">
            <label for='password' id='labelID2'>Heslo</label>
            <input type="password" name="password" placeholder="Heslo" required="required">
        </div>
        <div>

        </div>
        <button type="submit" name="login_user"><strong>Prihlásiť sa</strong>
        </button>
    </form>
</div>

</body>
</html>
