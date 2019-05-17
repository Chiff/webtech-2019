<?php
	$baseFolder = "http://".$_SERVER['HTTP_HOST'].str_replace($_SERVER['DOCUMENT_ROOT'], "", dirname(__DIR__, 1));

	$css = $baseFolder."/assets/css";
	$js = $baseFolder."/assets/js";
?>
<!--TODO: vyplnit spravne meta tagy-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel='stylesheet' type='text/css' href='<?php echo $css ?>/main.css'>
<link rel='stylesheet' type='text/css' href='<?php echo $css ?>/bootstrap.min.css'>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script src='<?php echo $js ?>/main.js' type='module'></script>
<script src='<?php echo $js?>/translate.js' type='module'></script>

