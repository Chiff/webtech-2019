<?php
require_once('../src/helpers.php');

//temporary....................
//session_start();
//if (!isset($_SESSION['username'])) {
//    $_SESSION['msg'] = "You must log in first";
//    header('location: login/index.php');
//} else if (isset($_POST['log_out'])) {
//    session_destroy();
//    unset($_SESSION['username']);
//    header("location: login/index.php");
//}
// end temporary....................
?>
<!DOCTYPE html>
<head>
    <title>Import test</title>
    <?php include('head.php'); ?>
</head>
<body>
<?php include('nav.php'); ?>
<div id = "tmpDvv">
    <!--netrebalo by if-->
    <h1>Welcome <?php if (isset($_SESSION["username"])) echo $_SESSION["username"];  ?></h1>
    <h2>Log in through <?php if (isset($_SESSION["login"])) echo $_SESSION["login"];  ?></h2>
    <h3>uid = <?php echo $_SESSION["uid"]?></h3>
    <h3>admin heslo = <?php echo $_SESSION["admin_password"]?></h3>

    <span data-translate>Ahoj <span>neprekladaj</span> preloz</span>

    <form action="index.php" method="post">
        <button type="submit" name="log_out">
            Odhlásiť sa
        </button>
    </form>
</div>
</body>
