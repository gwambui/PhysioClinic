<?php

session_start();

unset($_SESSION['user']);

include("shared/header.php"); ?>

<p style="text-align:center">You have been logged off, thank you for using the system.</p>
<p style="text-align:center">
    <a href="https://ltc55311.encs.concordia.ca">
        <button class="btn btn-primary"><i class='fa fa-repeat'></i>&nbsp;Reload System</button>
    </a>
</p>

<?php include("shared/footer.php"); ?>


