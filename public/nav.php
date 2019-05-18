<?php
$baseFolder = "http://" . $_SERVER['HTTP_HOST'] . str_replace($_SERVER['DOCUMENT_ROOT'], "", dirname(__DIR__, 1));
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<a class="navbar-brand" href="<?php echo $baseFolder?>/public/">Itchy & Sketchy</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
		<div class="navbar-nav mt-1">
			<a class="nav-item nav-link" href="<?php echo $baseFolder?>/public/">Uvod</a>
            <?php if ($_SESSION['username'] == 'admin') echo '<a class="nav-item nav-link" href=' . $baseFolder. '/public/admin>Admin</a>'?>
<!--			<a class="nav-item nav-link" href="--><?php //echo $baseFolder?><!--/public/admin">Admin</a>-->
		</div>
		<div class="form-inline my-2 ml-auto">
			<form action="<?php echo $baseFolder?>/public/" method="post">
				<button class="btn btn-outline-danger my-2 my-sm-0" type="submit" name="log_out">
					Odhlásiť sa
				</button>
			</form>
		</div>
	</div>
</nav>
