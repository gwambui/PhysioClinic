<?php
/**
 * Created by PhpStorm.
 * User: bwood
 * Date: 2017-07-25
 * Time: 1:40 PM
 */

function GetDailyMessage()
{
    date_default_timezone_set('America/New_York');

    $hour = date('H');
    $dayTerm = ($hour > 17) ? "Evening" : ($hour > 12) ? "Afternoon" : "Morning";
    return "Good " . $dayTerm;
}