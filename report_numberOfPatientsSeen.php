<?php/*
session_start();
require_once 'shared/access_validate.php';*/
require_once 'BAL/BA.php';

//Checking userType
if (!in_array($_SESSION['user']['Type_ID'], array(AuthENUMS::ADMIN,AuthENUMS::SUPERVISOR, AuthENUMS::SUPERVISOR, AuthENUMS::ADMIN)))
{
    header('Location: report_home.php');
}


include("shared/header.php");
include("shared/top_bar.php");

$rba = new reportingBA();

$start = empty($_POST['from']) ? date_sub(date_create(date("Y-m-d H:i:s")), new DateInterval("P10D")) : date_create($_POST['from']);
$end = empty($_POST['to']) ? date_create(date("Y-m-d H:i:s")) : date_create($_POST['to']);

$rows = $rba->GetNumberOfPatientsSeenReport($start, $end);
?>

<link href="/assets/css/report_style.css" rel="stylesheet">

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">

                <li ><a href="report_home.php">Report Overview <span class="sr-only">(current)</span></a></li>

                <? if (in_array($_SESSION['user']['Type_ID'], array(AuthENUMS::ADMIN, AuthENUMS::SUPERVISOR, AuthENUMS::ADMIN))) { ?>
                    <li class="active"><a href="report_numberOfPatientsSeen.php"><i class='fa fa-file-text-o'></i>&nbsp;Patient Consultation Report</a></li><? } ?>

                <? if (in_array($_SESSION['user']['Type_ID'], array(AuthENUMS::ADMIN, AuthENUMS::SUPERVISOR, AuthENUMS::ADMIN, AuthENUMS::DOCTOR, AuthENUMS::THERAPIST))) { ?>
                    <li><a href="report_unusedEquipment.php"><i class='fa fa-file-text-o'></i>&nbsp;Unused Equipment Report</a></li><? } ?>

                <? if (in_array($_SESSION['user']['Type_ID'], array(AuthENUMS::ADMIN, AuthENUMS::SUPERVISOR, AuthENUMS::ADMIN))) { ?>
                    <li><a href="report_patients_seen_at_center.php"><i class='fa fa-file-text-o'></i>&nbsp;Patient Seen At Center</a></li><? } ?>

                <? if (in_array($_SESSION['user']['Type_ID'], array(AuthENUMS::ADMIN, AuthENUMS::SUPERVISOR, AuthENUMS::ADMIN))) { ?>
                    <li><a href="report_therapist_at_center.php"><i class='fa fa-file-text-o'></i>&nbsp;Info On Therapists Working At Center</a></li><? } ?>

                <? if (in_array($_SESSION['user']['Type_ID'], array(AuthENUMS::ADMIN, AuthENUMS::SUPERVISOR, AuthENUMS::ADMIN, AuthENUMS::DOCTOR, AuthENUMS::THERAPIST))) { ?>
                    <li><a href="report_patient_reservations.php"><i class='fa fa-file-text-o'></i>&nbsp;Patient Reservations Report</a></li><? } ?>

                <? if (in_array($_SESSION['user']['Type_ID'], array(AuthENUMS::ADMIN, AuthENUMS::SUPERVISOR, AuthENUMS::ADMIN, AuthENUMS::DOCTOR, AuthENUMS::THERAPIST))) { ?>
                    <li><a href="report_therapist_availability.php"><i class='fa fa-file-text-o'></i>&nbsp;Doctor/Therapist Availability Report</a></li><? } ?>

                <? if (in_array($_SESSION['user']['Type_ID'], array(AuthENUMS::ADMIN, AuthENUMS::SUPERVISOR, AuthENUMS::PATIENT))) { ?>
                    <li><a href="report_patient_prescriptions.php"><i class='fa fa-file-text-o'></i>&nbsp;Patient List of Prescriptions</a></li><? } ?>

                <? if (in_array($_SESSION['user']['Type_ID'], array(AuthENUMS::ADMIN, AuthENUMS::SUPERVISOR, AuthENUMS::DOCTOR))) { ?>
                    <li><a href="report_patients_without_appointment.php"><i class='fa fa-file-text-o'></i>&nbsp;Patients With Prescription but no Appointment</a></li><? } ?>

                <? if (in_array($_SESSION['user']['Type_ID'], array(AuthENUMS::ADMIN, AuthENUMS::SUPERVISOR, AuthENUMS::THERAPIST))) { ?>
                    <li><a href="report_heavy_used_equipment.php"><i class='fa fa-file-text-o'></i>&nbsp;Frequently Used Equipment</a></li><? } ?>

                <? if (in_array($_SESSION['user']['Type_ID'], array(AuthENUMS::ADMIN, AuthENUMS::SUPERVISOR, AuthENUMS::ADMIN))) { ?>
                    <li><a href="report_patient_count_by_agegroup.php"><i class='fa fa-file-text-o'></i>&nbsp;Patient Count By Age Group</a></li><? } ?>
            </ul>
        </div>

        <div class="col-sm-6 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <div id="main" class="container"
                 style="background: white; border-radius: 6px; padding: 20px; margin-top: 20px;">

                <h2>Patient Consultation Report</h2>
                <p><i>Note: Default time period showing past 10 days, please change range to override.</i></p>

                <form action="<? echo $_SERVER['PHP_SELF']; ?>" method='post'>
                    <div class="row">
                        <div class="col-sm-3 col-md-3"><label for="from">From</label>
                            <input type="datetime-local" name="from" class="form-control" id="from"
                                   value="<? echo $start->format("Y-m-d\TH:i"); ?>"></div>
                        <div class="col-sm-3 col-md-3"><label for="from">To</label>
                            <input type="datetime-local" name="to" class="form-control" id="to"
                                    value="<? echo $end->format("Y-m-d\TH:i"); ?>">
                        </div>
                        <div class="col-sm-6 col-md-6">&nbsp;</div>
                    </div>
                    <!-- 1985-04-12T23:20 -->
                    <div class="row">
                        <div class="col-sm-12 col-md-12"><input type="submit" value="Refresh" class="btn btn-primary"></div>
                        <div class="col-sm-12 col-md-12">&nbsp;</div>
                    </div>
                </form>

                <?php
                if (count($rows) > 0)
                {
                    echo "<table class='table table-striped'>";
                    echo "<tr>";
                    foreach ($rows[0] as $item => $value) {
                        echo "<th>$item</th>";
                    }
                    echo "</tr>";

                    foreach ($rows as $item => $value) {
                        echo "<tr>";
                        foreach ($value as $field) {
                            echo "<td>$field</td>";
                        }

                        echo "</tr>";
                    }

                    echo "</table>";
                }?>

                <b>Total Rows: <? echo count($rows); ?></b>

            </div>

        </div>
    </div>
</div>

<?php include("shared/footer.php"); ?>
