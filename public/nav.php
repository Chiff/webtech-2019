<?php
$baseFolder = "http://" . $_SERVER['HTTP_HOST'] . str_replace($_SERVER['DOCUMENT_ROOT'], "", dirname(__DIR__, 1));
?>

<nav>
    <a href="<?php echo $baseFolder?>/public/">Uvod</a>
    <a href="<?php echo $baseFolder?>/public/admin">Admin</a>
</nav>
