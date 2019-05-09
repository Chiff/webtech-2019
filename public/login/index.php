<?php
require('../../config/config.php');
session_start();
$db = mysqli_connect($hostname, $username, $password, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
date_default_timezone_set('	Europe/Bratislava');

if (isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You are log in already";
    header('location: ../index.php');
}

if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if ($username && $password) { //dal meno a heslo
        $login_name_db = mysqli_query($db, "SELECT * FROM student WHERE login='$username'"); //Zmenit
        if (mysqli_num_rows($login_name_db) == 1) { //ak najde studenta
            $row = mysqli_fetch_row($login_name_db);
            var_dump(password_verify($password, $row[3]));
            if (password_verify($password, $row[3])){ //Porovnanie hesiel
                $_SESSION['username'] = $username;
                $_SESSION['login'] = 'generated password';
                header('location: ../index.php');
            } else { //LDAP
                $ds = ldap_connect($ldap_server);
                $dn = "uid=" . $username . ", " . $dn_default;
                ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
                if ($ds) {
                    if ($bind = @ldap_bind($ds, $dn, $password)) {
                        $_SESSION['username'] = $username;
                        $_SESSION['login'] = 'LDAP';
                        header('location: ../index.php');
                        echo "LDAP";
                    } else {
                        echo "Zadali ste chybné meno alebo heslo";
                    }
                } else {
                    echo "Nedá sa pripojiť ns LDAP server.";
                }
            }
        } else
            echo "Študent s daným loginom sa nenachádza v databáze";
    }
}

mysqli_close($db);
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
    <form action="index.php" method="post">
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
