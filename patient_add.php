<?php
session_start();
require_once 'shared/access_validate.php';
require_once 'BAL/BA.php';

//Checking userType
if (!in_array($_SESSION['user']['Type_ID'], array(
    AuthENUMS::ADMIN,
    AuthENUMS::SUPERVISOR
)))
{
    header('Location: index.php');
}


include("shared/header.php");
include("shared/top_bar.php");


$post = $_SERVER['REQUEST_METHOD'] == 'POST' ? true : false;




$cba = new ClinicBA();
$dba = new DoctorBA();
$tba = new TreatmentBA();

$doctorLookup = $dba->GetDoctors();
$clinicLookup = $cba->GetClinics();
$treatmentLookup = $tba->GetTreatments();
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


        <form class="form-horizontal" role="form" method="post" action="patient_add.php">
            <h1>New Patient</h1>

            <div id="patient_info" class="row">

                <div class="col-md-5 col-sm-5">


                    <h2>Patient Information</h2>
                    <div class="form-group">
                        <label for="firstName" class="col-sm-3 control-label">Family Name</label>
                        <div class="col-sm-6">
                            <input <? echo $post ? "disabled='disabled'" : ""; ?> type="text" id="lastName"
                                                                                  name="lastName"
                                                                                  placeholder="Family Name"
                                                                                  class="form-control" autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="firstName" class="col-sm-3 control-label">Given Name</label>
                        <div class="col-sm-6">
                            <input <? echo $post ? "disabled='disabled'" : ""; ?> type="text" id="firstName"
                                                                                  name="firstName"
                                                                                  placeholder="Given Name"
                                                                                  class="form-control" autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="userName" class="col-sm-3 control-label">UserName (Login Name)</label>
                        <div class="col-sm-6">
                            <input <? echo $post ? "disabled='disabled'" : ""; ?> type="text" id="userName"
                                                                                  name="userName" placeholder="UserName"
                                                                                  class="form-control" autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-sm-3 control-label">Password</label>
                        <div class="col-sm-6">
                            <input <? echo $post ? "disabled='disabled'" : ""; ?> type="password" id="password"
                                                                                  name="password" placeholder="Password"
                                                                                  class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="birthDate" class="col-sm-3 control-label">Date of Birth</label>
                        <div class="col-sm-6">
                            <input <? echo $post ? "disabled='disabled'" : ""; ?> type="date" id="birthDate"
                                                                                  name="birthDate" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phoneNumber" class="col-sm-3 control-label">Phone Number</label>
                        <div class="col-sm-6">
                            <input <? echo $post ? "disabled='disabled'" : ""; ?> type="text" id="phoneNumber"
                                                                                  name="phoneNumber"
                                                                                  placeholder="Phone Number (555) 555-5555"
                                                                                  class="form-control" autofocus>
                        </div>
                    </div>

                </div>

                <div class="col-md-5 col-sm-5">


                    <h2>Prescription Information</h2>

                    <div class="form-group">
                        <label for="prescription" class="col-sm-3 control-label">Prescription</label>
                        <div class="col-sm-6">
                            <textarea <? echo $post ? "disabled='disabled'" : ""; ?> class="form-control"
                                                                                     id="prescription"
                                                                                     name="prescription"
                                                                                     placeholder="Prescription"
                                                                            required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="prescription_number" class="col-sm-3 control-label">Prescription Number</label>
                        <div class="col-sm-6">
                            <input <? echo $post ? "disabled='disabled'" : ""; ?> type="text" id="prescription_number"
                                                                                  name="prescription_number"
                                                                                  placeholder="Prescription Number"
                                                                                  class="form-control" required >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pres_doctor" class="col-sm-3 control-label">Doctor's Name</label>
                        <div class="col-sm-6">
                            <input <? echo $post ? "disabled='disabled'" : ""; ?> type="text" id="pres_doctor"
                                                                                  name="pres_doctor"
                                                                                  placeholder="Issuing External Doctor's Name"
                                                                                  class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="issued_by_license" class="col-sm-3 control-label">Doctor's License</label>
                        <div class="col-sm-6">
                            <input <? echo $post ? "disabled='disabled'" : ""; ?> type="text" id="issued_by_license"
                                                                                  name="issued_by_license"
                                                                                  placeholder="Issuing Doctor's License"
                                                                                  class="form-control" required>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="pres_doctor" class="col-sm-3 control-label">Prescribed Specialist/Clinic</label>
                        <div class="col-sm-6">

                            <select class="form-control" required
                                    name="specialistClinic" <? echo $post ? "disabled='disabled'" : ""; ?>>
                                <?
                                echo "<option value='' selected='selected'></option>";

                                foreach ($doctorLookup as $item => $value) {

                                    $clinic = $cba->GetClinic($value['Center_ID']);
                                    echo "<option value=" . $value['EmployeeID'] . ">Dr. " . $value['FirstName']
                                        . " " . $value['LastName'] . " (Clinic: " . $clinic['Name'] . ")" . "</option>";
                                } ?>
                            </select>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pres_doctor" class="col-sm-3 control-label">Treatment</label>
                        <div class="col-sm-6">
                            <select class="form-control" required
                                    name="treatment" <? echo $post ? "disabled='disabled'" : ""; ?>>
                                <?
                                echo "<option value='' selected='selected'></option>";
                                foreach ($treatmentLookup as $item => $value) {
                                    echo "<option value=" . $value['ID'] . ">" . $value['Name'] . "</option>";
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="createApptFlag" class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <input type="checkbox" id="createApptFlag" name="createApptFlag" value="create"
                            <? echo $post ? "disabled='disabled'" : ""; ?>>&nbsp;Check here to create an appointment.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pres_datetime" class="col-sm-3 control-label">Prescribed Time and Date</label>
                        <div class="col-sm-6">
                            <input <? echo $post ? "disabled='disabled'" : ""; ?>
                                    type="datetime-local"
                                    id="pres_datetime"
                                    name="pres_datetime"
                                    placeholder="Appointment Date and Time"
                                    lass="form-control" autofocus>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <div class="col-sm-3">
                <button <? echo $post ? "disabled='disabled'" : ""; ?> type="submit" class="btn btn-primary btn-block">
                    Register Patient
                </button>
                <br>


            </div>
        </form>
        <a href="/index.php">
            <button class="btn btn-primary">Return to Main Menu</button>
        </a>
    </div>

<? if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>

    <style type="text/css">#main {
            disabled: true;
        }</style>

    <div class="container" style="background: white; border-radius: 6px; padding: 20px; margin-top: 20px;">

        <?
        // Patient and User Stuff
        $lastName = $_POST['lastName'];
        $firstName = $_POST['firstName'];
        $userName = $_POST['userName'];
        $phoneNumber = $_POST['phoneNumber'];
        $password = $_POST['password'];
        $birthDate = $_POST['birthDate'];
        $prescription = $_POST['prescription'];
        $pres_doctor = $_POST['pres_doctor'];

        // Prescription Stuff
        $notes = $_POST['prescription'];
        $issuedByTrainer = $_POST['pres_doctor'];
        $specialistId = $_POST['specialistClinic'];
        $treatment = $_POST['treatment'];
        $prescriptionNumber = $_POST['prescription_number'];
        $issuedByLicense = $_POST['issued_by_license'];
        $prescriptionStatusID = 1; // Active

        // Appointment Stuff
        $appointmentDateTime = $_POST['pres_datetime'];

        $pba = new PatientBA();
        $uba = new UserBA();
        $prba = new PrescriptionBA();
        $aba = new AppointmentBA();

        $patientDTO = new PatientAddDTO(
            null, $birthDate, $phoneNumber,
            $prescriptionId, null,
            $userName, $firstName, $lastName,
            $password, 2);


        try {

            if ( !empty($notes) && !empty($issuedByTrainer) && !empty($specialistId) && !empty($treatment) && !empty($prescriptionNumber) && !empty($issuedByLicense) ) {

                $patientId = $pba->AddPatient($patientDTO);

                $prescriptionDTO = new PrescriptionDTO(
                    null, $prescriptionNumber, $patientId, $issuedByTrainer,
                    $issuedByLicense, $specialistId, $treatment,
                    $prescriptionStatusID, $notes);

                $prescriptionId = $prba->AddPrescription($prescriptionDTO);


                $createAppt = $_POST['createApptFlag'];

                if ($createAppt == "create") {
                    $sqlFormattedDateTimeNow = date_create(date('Y-m-d H:i:s'));
                    $sqlFormattedDateTime = date_create($appointmentDateTime);
                    $sqlFormattedDateTimeEnd = date_create($appointmentDateTime);
                    $sqlFormattedDateTimeEnd->modify('+1 hour');

                    $appointmentDTO = new AppointmentDTO(null, $patientId, $prescriptionId,
                        $sqlFormattedDateTimeNow, $sqlFormattedDateTime,
                        $sqlFormattedDateTimeEnd, 1); // 1 = Booked

                    $aba->AddAppointment($appointmentDTO);
                }

                echo '<div class="alert alert-success"><p>Record Successfully Added.</p><p>New User ID is '
                    . $patientDTO->User_ID
                    . ' and patient ID is ' . $patientDTO->ID . '</p></div>';

                if ($createAppt == "create") {
                    echo '<div class="alert alert-warning"><p>Appointment was added as requested.</p></div>';
                }

                echo '<a href="index.php"><button class="form-control btn btn-primary">'
                    . 'Click here to Return to the Main Menu</button></a>';
            }
            else
            {
                echo "<div class='alert alert-danger'>Prescription info MUST be entered, please try again.</div>";
                echo '<a href="index.php"><button class="form-control btn btn-primary">'
                    . 'Click here to Return to the Main Menu</button></a>';
            }
        } catch (PDOException $pex) {
            echo '<div class="alert alert-danger">An error has occurred.<br>' . $pex->getCode() == 0 ? $pex->getMessage() : $pex->getCode()  . '</div>';
            echo '<a href="index.php"><button class="form-control btn btn-primary">'
                . 'Click here to Return to the Main Menu</button></a>';
        }
        ?>
    </div>
<? } ?>

<?php include("shared/footer.php"); ?>