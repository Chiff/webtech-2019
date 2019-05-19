<?php
$baseFolder = "http://" . $_SERVER['HTTP_HOST'] . str_replace($_SERVER['DOCUMENT_ROOT'], "", dirname(__DIR__, 1));
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?php echo $baseFolder ?>/public/">WT2019</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav mt-1">
            <a class="nav-item nav-link" href="<?php echo $baseFolder ?>/public/" data-translate>Uvod</a>
            <?php if ($_SESSION['username'] != 'admin') echo '<a class="nav-item nav-link" href=' . $baseFolder . '/public/eval data-translate>Evaluacia</a>' ?>
            <?php if ($_SESSION['username'] == 'admin') echo '<a class="nav-item nav-link" href=' . $baseFolder . '/public/admin>Admin</a>' ?>
            <?php if ($_SESSION['username'] == 'admin') echo '<a class="nav-item nav-link" href=' . $baseFolder . '/public/info data-translate>Ulohy</a>' ?>
            <?php if ($_SESSION['username'] == 'admin') echo '<a class="nav-item nav-link" href=' . $baseFolder . '/public/admin/server-data-generator.php data-translate>Prihlasovacie udaje</a>' ?>
            <?php if ($_SESSION['username'] == 'admin') echo '<a class="nav-item nav-link" href=' . $baseFolder . '/public/admin/mail-statistics.php data-translate>Mail štatistiky</a>' ?>
            <?php if ($_SESSION['username'] == 'admin') echo '<a class="nav-item nav-link" href=' . $baseFolder . '/public/admin/project-statistics.php data-translate>Štatistiky projektov</a>' ?>
        </div>

        <div class="form-inline my-2 ml-auto">
            <button class="btn btn-outline-info mr-2" onclick="setLanguage('sk')">SK</button>
            <button class="btn btn-outline-info mr-2" onclick="setLanguage('en')">EN</button>
            <form action="<?php echo $baseFolder ?>/public/" method="post">
                <button class="btn btn-outline-danger my-2 my-sm-0" type="submit" name="log_out">
                    <span data-translate>Odhlásiť sa</span>
                </button>
            </form>
        </div>
    </div>
</nav>
