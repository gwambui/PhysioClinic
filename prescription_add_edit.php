<?php
session_start();
require_once 'shared/access_validate.php';
require_once 'BAL/BA.php';

//Checking userType
if (in_array($_SESSION['user']['Type_ID'], array(
    AuthENUMS::PATIENT
)))
{
    header('Location: index.php');
}


include("shared/header.php");
include("shared/top_bar.php");

$prba = new PrescriptionBA();
$pba = new PatientBA();
$cba = new ClinicBA();
$dba = new DoctorBA();
$tba = new TreatmentBA();

$doctorLookup = $dba->GetDoctors();
$clinicLookup = $cba->GetClinics();
$treatmentLookup = $tba->GetTreatments();

$action = null;
$userId = null;
$appointmentId = null;

$post = $_SERVER['REQUEST_METHOD'] == 'POST' ? true : false;
$self = $_SERVER['PHP_SELF'];

if (!empty($_GET['forUser']))
    $userId = $_GET['forUser'];

if (!empty($_POST['forUser']))
    $userId = $_POST['forUser'];

if (!empty($_GET['action']))
    $action = $_GET['action'];

if (!empty($_POST['action']))
    $action = $_POST['action'];

if (!empty($_GET['actionId']))
    $prescriptionId = $_GET['actionId'];

if (!empty($_POST['actionId']))
    $prescriptionId = $_POST['actionId'];

// For updates.
if (!is_null($prescriptionId))
{
    $currentPrescription = $prba->GetPrescriptionById($prescriptionId);
}

$prescriptionLookup = $prba->GetPrescriptionsForUser($userId);

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
        <img src="/assets/img/prescription.png" width="100" style="float:right">
        <form class="form-horizontal" method="post" action="<? echo $self; ?>">
            <h1><? ?></h1>
            <div id="patient_info" class="row">
                <div class="col-md-8 col-sm-8">
                    <h2><? echo $action == "add" ? "Add" : "Edit"; ?> Prescription</h2>


                        <h2>Prescription Information</h2>

                        <input type="hidden" name="prescription_id" value="<? echo $currentPrescription['ID']; ?>">
                        <input type="hidden" name="prescriptionstatus_id" value="<? echo $action == "add" ? "1" : $currentPrescription['PrescriptionStatus_ID']; ?>">

                        <div class="form-group">
                            <label for="prescription" class="col-sm-3 control-label">Prescription</label>
                            <div class="col-sm-6">
                            <textarea <? echo $post ? "disabled='disabled'" : ""; ?> class="form-control"
                                                                                     autofocus
                                                                                     id="prescription"
                                                                                     name="prescription"
                                                                                     placeholder="Prescription"

                            ><? echo !empty($currentPrescription) ? $currentPrescription['Notes'] : "";  ?></textarea>
                            </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="prescription_number" class="col-sm-3 control-label">Prescription Number</label>
                            <div class="col-sm-6">
                                <input <? echo $post ? "disabled='disabled'" : ""; ?> type="text" id="prescription_number"
                                                                                      name="prescription_number"
                                                                                      placeholder="Prescription Number"
                                                                                      class="form-control"
                                value="<? echo !empty($currentPrescription) ? $currentPrescription['PrescriptionNumber'] : "";  ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pres_doctor" class="col-sm-3 control-label">Doctor's Name</label>
                            <div class="col-sm-6">
                                <input <? echo $post ? "disabled='disabled'" : ""; ?> type="text" id="pres_doctor"
                                                                                      name="pres_doctor"
                                                                                      placeholder="Issuing External Doctor's Name"
                                                                                      class="form-control"
                                value="<? echo !empty($currentPrescription) ? $currentPrescription['IssuedByTrainer'] : "";  ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="issued_by_license" class="col-sm-3 control-label">Doctor's License</label>
                            <div class="col-sm-6">
                                <input <? echo $post ? "disabled='disabled'" : ""; ?> type="text" id="issued_by_license"
                                                                                      name="issued_by_license"
                                                                                      placeholder="Issuing Doctor's License"
                                                                                      class="form-control"
                                value="<? echo !empty($currentPrescription) ? $currentPrescription['IssuedByLicence'] : "";  ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pres_doctor" class="col-sm-3 control-label">Prescribed Specialist/Clinic</label>
                            <div class="col-sm-6">

                                <select class="form-control" name="specialistClinic" <? echo $post ? "disabled='disabled'" : ""; ?>>
                                    <?
                                    echo "<option value='' selected></option>";

                                    foreach ($doctorLookup as $item => $value) {

                                        $selected = $currentPrescription['Specialist_ID'] == $value['EmployeeID'] ? "selected" : "";

                                        $clinic = $cba->GetClinic($value['Center_ID']);
                                        echo "<option $selected value=" . $value['EmployeeID'] . ">Dr. " . $value['FirstName'] . " " . $value['LastName'] . " (Clinic: " . $clinic['Name'] . ")" . "</option>";
                                    } ?>
                                </select>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pres_doctor" class="col-sm-3 control-label">Treatment</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="treatment" <? echo $post ? "disabled='disabled'" : ""; ?>>
                                    <?
                                    echo "<option value='' selected></option>";

                                    foreach ($treatmentLookup as $item => $value)
                                    {
                                        $selected = $currentPrescription['Treatment_ID'] == $value['ID'] ? "selected" : "";

                                        echo "<option $selected value=" . $value['ID'] . ">" . $value['Name'] . "</option>";
                                    } ?>
                                </select>
                            </div>
                        </div>
                </div>
            </div>
            <hr>
            <div class="col-sm-3">
                <input type="hidden" name="action" value="<? echo $action; ?>">
                <input type="hidden" name="forUser" value="<? echo $userId; ?>">
                <button <? echo $post ? "disabled='disabled'" : ""; ?> type="submit" class="btn btn-success btn-block">
                    SAVE
                </button>
            </div>
        </form>
        <form action="prescription_manage.php" method="post">
            <input type="hidden" name="forUser" value="<? echo $userId ?>">
            <input type="submit" value="Back to Prescription Management" class="btn btn-primary" >
        </form>
    </div>

<? if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>

    <style type="text/css">#main {
            disabled: true;
        }</style>

    <div class="container" style="background: white; border-radius: 6px; padding: 20px; margin-top: 20px;">

        <?
        // Prescription Stuff
        $prescriptionId  = $_POST['prescription_id'];
        $prescription = $_POST['prescription'];
        $pres_doctor = $_POST['pres_doctor'];
        $notes = $_POST['prescription'];
        $issuedByTrainer = $_POST['pres_doctor'];
        $specialistId = $_POST['specialistClinic'];
        $treatment = $_POST['treatment'];
        $prescriptionNumber = $_POST['prescription_number'];
        $issuedByLicense = $_POST['issued_by_license'];
        $prescriptionStatusID = $_POST['prescriptionstatus_id']; // Active


        $patient = $pba->GetPatientByUserId($userId);

        $prescriptionDTO = new PrescriptionDTO($prescriptionId, $prescriptionNumber, $patient['ID'], $issuedByTrainer, $issuedByLicense,
            $specialistId, $treatment, $prescriptionStatusID, $notes);

        try
        {
            if ($action=="add") {
                $prba->AddPrescription($prescriptionDTO);
                echo '<div class="alert alert-success"><p>Record Successfully Added.</p></div>';

            }
            if ($action=="edit") {
                $prba->ModifyPrescription($prescriptionDTO);
                echo '<div class="alert alert-success"><p>Record Successfully Edited.</p></div>';
            }
            echo '<a href="index.php"><button class="form-control btn btn-primary">Click here to Return to the Main Menu</button></a>';
        }
        catch (PDOException $pex)
        {
            echo '<div class="alert alert-danger">An error has occurred.<br>' . $pex->getMessage() . '</div>';
            echo '<a href="index.php"><button class="form-control btn btn-primary">Click here to Return to the Main Menu</button></a>';
        }
        ?>
    </div>
<? } ?>

<?php include("shared/footer.php"); ?>