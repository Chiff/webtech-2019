<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 9. 5. 2019
 * Time: 9:39
 */
require_once('../config/config.php');
session_start();

$db = mysqli_connect($hostname, $username, $password, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if (isset($_POST['login_user'])) {
    $login_username = mysqli_real_escape_string($db, $_POST['username']);
    $login_password = mysqli_real_escape_string($db, $_POST['password']);
    if ($login_username && $login_password) { //dal meno a heslo
        $login_name_db = mysqli_query($db, "SELECT * FROM student WHERE login='$login_username'"); //Zmenit
        if (mysqli_num_rows($login_name_db) == 1) { //ak najde studenta
            $row = mysqli_fetch_row($login_name_db);
            $_SESSION['uid'] =  $row[0];
            var_dump(password_verify($login_password, $row[3]));
            if (password_verify($login_password, $row[3])) { //Porovnanie hesiel
                $_SESSION['username'] = $login_username;
                $_SESSION['login'] = 'generated password';
                header('location: ../public/index.php');
            } else { //LDAP
                $ds = ldap_connect($ldap_server);
                $dn = "uid=" . $login_username . ", " . $dn_default;
                ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
                if ($ds) {
                    if ($bind = @ldap_bind($ds, $dn, $login_password)) {
                        $_SESSION['username'] = $login_username;
                        $_SESSION['login'] = 'LDAP';
                        header('location: ../public/index.php');
                        echo "LDAP";
                    } else {
                        $_SESSION["login_message"] = "Zadali ste chybné meno alebo heslo";
                        header('location: ../public/login/index.php');
                    }
                } else {
                    $_SESSION["login_message"] = "Nedá sa pripojiť ns LDAP server.";
                    header('location: ../public/login/index.php');
                }
            }
        } else {
            $_SESSION["login_message"] = "Študent s daným loginom sa nenachádza v databáze";
            header('location: ../public/login/index.php');
        }
    }
}

mysqli_close($db);
