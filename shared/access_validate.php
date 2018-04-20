<?php

// Redirect if the session isn't established.
// Not super secure but OK for an academic project.
if (!isset($_SESSION['user']))
{
    header('Location: login.php');
}


