<?php
$baseFolder = "http://" . $_SERVER['HTTP_HOST'] . str_replace($_SERVER['DOCUMENT_ROOT'], "", dirname(__DIR__, 1));

$css =  $baseFolder . "/assets/css/main.css";
$js =  $baseFolder . "/assets/js/main.js";
?>

<link rel='stylesheet' type='text/css' href='http://147.175.121.210:8153/z2/style.css'>
<link rel='stylesheet' type='text/css' href='<?php echo $css?>'>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
<script src='<?php echo $js?>' type='module'></script>
