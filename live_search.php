<?php

require_once 'DAL/DA.php';

if (!empty($_GET['q']))
{
    $q = $_GET['q'];

    $db = new PatientDA();
    $result = $db->searchPatient($q, 2);

    if (count($result) > 0) {

       echo "<div class='list-group'>";

       foreach($result as $row) {
           $name = $row['FirstName'] . " " . $row['LastName'];

           echo "<a href='patient_display.php?patientid=".$row['PatientID']."' class='list-group-item'>" .
               "<h3 class='list-group-item-heading'>$name</h3><h4 style='color: #1b6d85'>Patient #: " . $row['PatientID'] . "  , Login: "
               . $row['LoginID'] . "</h4></a>";
       }

       echo "</div";

    }
    else
    {
        echo "Nothing found!";
    }
}
