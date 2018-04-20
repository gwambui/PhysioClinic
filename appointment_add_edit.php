<?php
session_start();
require_once 'shared/access_validate.php';
require_once 'BAL/BA.php';

//Checking userType
if (!in_array($_SESSION['user']['Type_ID'], array(
    AuthENUMS::ADMIN,
    AuthENUMS::SUPERVISOR,
    AuthENUMS::PATIENT
)))
{
    header('Location: index.php');
}

include("shared/header.php");
include("shared/top_bar.php");

$prba = new PrescriptionBA();
$aba = new AppointmentBA();
$pba = new PatientBA();

$action = null;
$userId = null;
$appointmentId = null;

$post = $_SERVER['REQUEST_METHOD'] == 'POST' ? true : false;
$self = $_SERVER['PHP_SELF'];

if (!empty($_GET['forUser'])) $userId = $_GET['forUser'];
if (!empty($_POST['forUser'])) $userId = $_POST['forUser'];
if (!empty($_GET['action'])) $action = $_GET['action'];
if (!empty($_POST['action'])) $action = $_POST['action'];
if (!empty($_GET['actionId'])) $appointmentId = $_GET['actionId'];
if (!empty($_POST['actionId'])) $appointmentId = $_POST['actionId'];

// For updates.
if (!is_null($appointmentId)) {
    $currentAppointment = $aba->GetAppointmentById($appointmentId);
    $currentAppointmentStartDate = DateTime::createFromFormat("Y-m-d H:i:s", $currentAppointment['StartDateTime']);
    $currentEquipment = $aba->GetEquipmentForAppointment($appointmentId);
}

$prescriptionLookup = $prba->GetPrescriptionsForUser($userId);
$equipmentLookup = $aba->GetEquipmentList();
$appointmentStatusLookup = $aba->GetAppointmentStatuses();

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
        <img src="/assets/img/appointment.png" width="100" style="float:right">
        <form class="form-horizontal" method="post" action="<? echo $self; ?>">
            <div id="patient_info" class="row">
                <div class="col-md-8 col-sm-8">
                    <h2><? echo $action == "add" ? "Add" : "Edit"; ?> Appointment</h2>
                    <div class="form-group">
                        <label for="pres_datetime" class="col-sm-3 control-label">Appointment Start</label>
                        <div class="col-sm-6">
                            <input <? echo $post ? "disabled='disabled'" : ""; ?> type="datetime-local"
                                                                                  id="pres_datetime"
                                                                                  name="pres_datetime"
                                                                                  class="form-control date"
                                                                                  autofocus
                                                                                  value="<?
                                                                                  echo !$currentAppointmentStartDate
                                                                                      ? ""
                                                                                      : date_format($currentAppointmentStartDate,
                                                                                          "Y-m-d\TH:i"); ?>"
                            <!-- 1985-04-12T23:20 -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pres_datetime" class="col-sm-3 control-label">Appointment End</label>
                        <div class="col-sm-6">
                            <label>All appointments last 1 hour.</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pres_doctor" class="col-sm-3 control-label">Select Prescription</label>
                        <div class="col-sm-6">

                            <select class="form-control"
                                    name="prescription" <? echo $post ? "disabled='disabled'" : ""; ?>>
                                <?
                                echo "<option value='' ></option>";
                                foreach ($prescriptionLookup as $item => $value) {
                                    $selected = $currentAppointment['Prescription_ID'] == $value['ID'] ? "selected" : "";
                                    echo "<option $selected value=" . $value['ID'] . ">" . $value['PrescriptionNumber'] .
                                        " " . $value['TreatmentName'] . " (" . $value['IssuedByTrainer'] . ", " . $value['IssuedByLicence'] . ")" . "</option>";
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pres_doctor" class="col-sm-3 control-label">Select Equipment</label>
                        <div class="col-sm-6">

                            <select class="form-control" multiple size=20 style="height: 100%"
                                    name="equipment[]" <? echo $post ? "disabled='disabled'" : ""; ?>>

                                <?
                                foreach ($equipmentLookup as $item => $value) {
                                    $selected = in_array($value['ID'], array_column($currentEquipment, 'ID')) ? "selected" : "";
                                    echo "<option $selected value=" . $value['ID'] . ">" . $value['Name'] . "</option>";
                                } ?>
                            </select>
                        </div>
                    </div>

                    <? if ($action != "add") { ?>

                    <div class="form-group">
                        <label for="pres_doctor" class="col-sm-3 control-label">Change Appointment Status</label>
                        <div class="col-sm-6">
                            <select class="form-control"
                                    name="status" <? echo $post ? "disabled='disabled'" : ""; ?>>
                                <?
                                echo "<option value='' ></option>";
                                foreach ($appointmentStatusLookup as $item => $value) {
                                    $selected = $currentAppointment['Status_ID'] == $value['ID'] ? "selected" : "";
                                    echo "<option $selected value=" . $value['ID'] . ">" . $value['Name']
                                        . "</option>";
                                } ?>
                            </select>
                        </div>
                    </div>

                    <? } ?>

                </div>
            </div>
            <hr>
            <div class="col-sm-3">
                <input type="hidden" name="action" value="<? echo $action; ?>">
                <input type="hidden" name="forUser" value="<? echo $userId; ?>">
                <input type="hidden" name="actionId" value="<? echo $appointmentId; ?>">
                <button <? echo $post ? "disabled='disabled'" : ""; ?> type="submit" class="btn btn-success btn-block">
                    SAVE
                </button>
            </div>
        </form>
        <form action="appointment_manage.php" method="post">
            <input type="hidden" name="forUser" value="<? echo $userId ?>">
            <input type="submit" value="Back to Appointment Management" class="btn btn-primary">
        </form>
    </div>

<? if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>

    <style type="text/css">#main {
            disabled: true;
        }</style>

    <div class="container" style="background: white; border-radius: 6px; padding: 20px; margin-top: 20px;">

        <?

        // Posted values

        $appointmentDateTime = $_POST['pres_datetime'];
        $prescriptionId = $_POST['prescription'];
        $equipment = $_POST['equipment'];
        $status = $_POST['status'];

        $patient = $pba->GetPatientByUserId($userId);
        $patientId = $patient['ID'];

        try {
            $sqlFormattedDateTimeNow = date_create(date('Y-m-d H:i:s'));
            $sqlFormattedDateTime = date_create($appointmentDateTime);
            $sqlFormattedDateTimeEnd = date_create($appointmentDateTime);
            $sqlFormattedDateTimeEnd->modify('+1 hour');

            $appointmentDTO = new AppointmentDTO($appointmentId, $patientId, $prescriptionId,
                $sqlFormattedDateTimeNow, $sqlFormattedDateTime, $sqlFormattedDateTimeEnd, $status); // 1 = Booked

            if ($action == "add") {

                $appointmentDTO->Status_ID = 1;

                $a_id = $aba->AddAppointment($appointmentDTO);

                if (!empty($equipment)) {
                    foreach ($equipment as $equipmentId) {
                        $aba->AddEquipmentToAppointment($equipmentId, $a_id);
                    }
                }

                echo '<div class="alert alert-success"><p>Record Successfully Added.</p></div>';

            }
            if ($action == "edit") {
                $aba->ModifyAppointment($appointmentDTO);

                if (!empty($equipment)) {
                    foreach ($equipment as $equipmentId) {

                        if (!in_array($equipmentId, array_column($currentEquipment, 'ID')))
                            $aba->AddEquipmentToAppointment($equipmentId, $appointmentDTO->id);

                    }
                }

                echo '<div class="alert alert-success"><p>Record Successfully Edited.</p></div>';
            }
            echo '<a href="index.php"><button class="form-control btn btn-primary">Click here to Return to the Main Menu</button></a>';
        } catch (PDOException $pex) {
            echo '<div class="alert alert-danger">An error has occurred.<br>' . $pex->getMessage() . '</div>';
            echo '<a href="index.php"><button class="form-control btn btn-primary">Click here to Return to the Main Menu</button></a>';
        }
        ?>
    </div>
<? } ?>

<?php include("shared/footer.php"); ?>