<?php
session_start();
require_once 'shared/access_validate.php';
require_once "BAL/BA.php";

//Checking userType
if (in_array($_SESSION['user']['Type_ID'], array(
    AuthENUMS::PATIENT
)))
{
    header('Location: index.php');
}


include("shared/header.php");
include("shared/top_bar.php");

$uba = new UserBA();
$pba = new PatientBA();
$aba = new AppointmentBA();

$current_patient = $pba->GetPatient($_GET['patientid']);
?>

    <style>
        .col > div {
            background-color: white;
            height: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #aaa;
        }
    </style>

    <div id="main" class="container" style="background: white; border-radius: 6px; padding: 20px; margin-top: 20px;">

        <img src="/assets/img/patient.png" width="100" style="float:right">

        <h1>Patient Record</h1>

        <hr>

        <form class="form-horizontal" role="form" method="post" action="patient_add.php">

            <div class="form-group">
                <label for="ID" class="col-sm-3 control-label">Patient ID</label>
                <div class="col-sm-5">
                    <span class="form-control"><? echo $current_patient['PatientId']; ?></span>
                </div>
            </div>
            <div class="form-group">
                <label for="firstName" class="col-sm-3 control-label">Family Name</label>
                <div class="col-sm-5">
                    <span class="form-control"><? echo $current_patient['LastName']; ?></span>
                </div>
            </div>
            <div class="form-group">
                <label for="firstName" class="col-sm-3 control-label">Given Name</label>
                <div class="col-sm-5">
                    <span class="form-control"><? echo $current_patient['FirstName']; ?></span>
                </div>
            </div>
            <div class="form-group">
                <label for="firstName" class="col-sm-3 control-label">User Name</label>
                <div class="col-sm-5">
                    <span class="form-control"><? echo $current_patient['LoginID']; ?></span>
                </div>
            </div>
            <div class="form-group">
                <label for="firstName" class="col-sm-3 control-label">Phone Number</label>
                <div class="col-sm-5">
                    <span class="form-control"><? echo $current_patient['PhoneNumber']; ?></span>
                </div>
            </div>
            <div class="form-group">
                <label for="firstName" class="col-sm-3 control-label">Birth Date</label>
                <div class="col-sm-5">
                    <span class="form-control"><? echo $current_patient['BirthDate']; ?></span>
                </div>
            </div>
        </form>
        <hr>
    <!-- <form method="POST" action="appointment_manage.php" style="display:inline">
            <input type="hidden" name="forUser" value="<? echo $current_patient['ID']; ?>">
            <button class="btn btn-primary"><i class='fa fa-calendar'></i>&nbsp;Manage Appointments</button>
        </form> -->

     <form method="POST" action="prescription_manage.php" style="display:inline">
            <input type="hidden" name="forUser" value="<? echo $current_patient['ID']; ?>">
            <button class="btn btn-primary"><i class='fa fa-pencil-square-o'></i>&nbsp;Manage Prescriptions</button>
        </form>

    <!--<form method="POST" action="payments_manage.php" style="display:inline">
            <input type="hidden" name="forUser" value="<? echo $current_patient['ID']; ?>">
            <button class="btn btn-primary"><i class='fa fa-usd'></i>&nbsp;Manage Payments</button>
        </form> -->

        <? if (!in_array($_SESSION['user']['Type_ID'], array(AuthENUMS::DOCTOR, AuthENUMS::THERAPIST))) { ?>
            <form method="POST" action="appointment_manage.php" style="display:inline">
            <input type="hidden" name="forUser" value="<? echo $current_patient['ID']; ?>">
            <button class="btn btn-primary"><i class='fa fa-calendar'></i>&nbsp;Manage Appointments</button>
            </form><? } ?>


        <? if (!in_array($_SESSION['user']['Type_ID'], array(AuthENUMS::DOCTOR, AuthENUMS::THERAPIST))) { ?>
            <form method="POST" action="payments_manage.php" style="display:inline">
            <input type="hidden" name="forUser" value="<? echo $current_patient['ID']; ?>">
            <button class="btn btn-primary"><i class='fa fa-usd'></i>&nbsp;Manage Payments</button>
            </form><? } ?>

        <br><br>
        <a href="index.php">
            <button class=" btn btn-primary"><i class='fa fa-home'></i>&nbsp;Click here to Return to the Main Menu</button>
        </a>
    </div>

<?php
include("shared/footer.php");
?>