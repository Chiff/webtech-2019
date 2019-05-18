<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 9. 5. 2019
 * Time: 9:39
 */
require_once('../config/config.php');
session_start();
$baseFolder = "http://" . $_SERVER['HTTP_HOST'] . str_replace($_SERVER['DOCUMENT_ROOT'], "", dirname(__DIR__, 1));
//$_SESSION["foo"] = $baseFolder;
$db = mysqli_connect($hostname, $username, $password, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
//TODO
//<!--$baseFolder = "http://" . $_SERVER['HTTP_HOST'] . str_replace($_SERVER['DOCUMENT_ROOT'], "", dirname(_DIR_, 1));-->

if (isset($_POST['login_user'])) {
    $login_username = mysqli_real_escape_string($db, $_POST['username']);
    $login_password = mysqli_real_escape_string($db, $_POST['password']);
    if ($login_username && $login_password) { //dal meno a heslo
        $login_name_db = mysqli_query($db, "SELECT * FROM student WHERE login='$login_username'");
        if (mysqli_num_rows($login_name_db) == 1) { //ak najde studenta
            $row = mysqli_fetch_row($login_name_db);
            $_SESSION['uid'] = $row[0];
            if (password_verify($login_password, $row[3])) { //Porovnanie hesiel
                $_SESSION['username'] = $login_username;
                $_SESSION['login'] = 'Generated password';
                header('location: ../public/index.php');
            } else { //LDAP
                $ds = ldap_connect($ldap_server);
                $dn = "uid=" . $login_username . ", " . $dn_default;
                ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
                if ($ds) {
                    if ($bind = @ldap_bind($ds, $dn, $login_password)) {
                        $_SESSION['username'] = $login_username;
                        $_SESSION['login'] = 'LDAP';
                        header('location:'. $baseFolder. '/public/index.php');
                    } else {
                        $_SESSION["login_message"] = "Zadali ste chybné meno alebo heslo";
                        header('location:'. $baseFolder. '/public/login/index.php');
                    }
                } else {
                    $_SESSION["login_message"] = "Nedá sa pripojiť ns LDAP server.";
                    header('location:'. $baseFolder. '/public/login/index.php');
                }
            }
        } else {
            $_SESSION["login_message"] = "Študent s daným loginom sa nenachádza v databáze";
            header('location:'. $baseFolder. '/public/login/index.php');
        }
    }
}

//function redirect($login_username, $location){
//    $_SESSION["login_message"] = "Zadali ste chybné meno alebo heslo";
//    $_SESSION['username'] = $login_username;
//    $_SESSION['login'] = 'LDAP';
//    header('location: $location');
//}

mysqli_close($db);
