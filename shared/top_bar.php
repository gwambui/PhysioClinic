<? require_once "BAL/BA.php"; ?>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">BSPC Clinic</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="/"><i class='fa fa-home'></i>&nbsp;Home</a></li>

                <? if (in_array($_SESSION['user']['Type_ID'], array(
                    AuthENUMS::ADMIN,
                    AuthENUMS::SUPERVISOR,
                    AuthENUMS::DOCTOR,
                    AuthENUMS::THERAPIST,
                    AuthENUMS::PATIENT))) {?>

                <li><a href="report_home.php"><i class='fa fa-file-text-o'></i>&nbsp;Reports</a></li>
                <? } ?>

            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="logoff.php">Logged in as &nbsp;<i class='fa fa-user-circle-o'></i>&nbsp;<?php echo $_SESSION['user']['LoginID'] ?></a></li>
                <li><a href="logoff.php"><i class='fa fa-times'></i>&nbsp;Logoff</a></li>
            </ul>
        </div>
    </div>
</nav>