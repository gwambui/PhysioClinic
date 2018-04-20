<?php

require_once 'BAL/BA.php';
/*
$post = $_SERVER['REQUEST_METHOD'] == 'POST' ? true : false;

if ($post)
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sba = new SessionBA();
    $loggedin = $sba->Login($username, $password);

    if ($loggedin)
    {
        header("Location: index.php");
        die();
    }
    else
    {
        $error = "Sorry, there was an error logging in!  Try again.";
    }
}
*/
include("shared/header.php");
?>

<div class="container">
    <form class="form-signin" action="login.php" method="post">

        <h2 class="form-signin-heading">Please sign in</h2>
        <?php if(isset($message)) echo '<div name="message" class="alert alert-danger">' . $message . '</div>'?>
        <label for="inputName" class="sr-only">User Name</label>
        <input id="inputName" name="username" class="form-control" placeholder="Username" required autofocus>
        <br>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <br>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in&nbsp;<i class='fa fa-arrow-circle-right'></i></button>
        <?php if ($post) { ?>
        <br>
        <div class="alert alert-danger"><? echo "<b><i class='fa fa-warning'></i>&nbsp;" . $error . "</b>"; ?></div>
        <? } ?>
    </form>
</div>

<link href="/assets/css/login_styles.css" rel="stylesheet">

<?php include("shared/footer.php"); ?>