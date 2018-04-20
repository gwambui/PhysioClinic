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

$post = $_SERVER['REQUEST_METHOD'] == 'POST' ? true : false;

$aba = new AppointmentBA();
$uba = new UserBA();
$pba = new PatientBA();

if (!empty($_POST['forUser'])) {
    $forUser = $_POST['forUser'];
    $user = $uba->GetUserByID($forUser);
    $patient = $pba->GetPatientByUserId($forUser);
} else {
    $user = $uba->GetUserByID($_SESSION['user']['ID']);
}

$userId = $user['ID'];
$action = $_POST['action'];
$actionId = $_POST['actionId'];

if ($action == 'cancel') {
    try {
        $aba->CancelAppointment($actionId);

        echo "<script>alert('Appointment Cancelled.')</script>";

    } catch (PDOException $e) {
        echo "<div class='alert alert-danger alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Error! </strong>" . $e->getMessage() . "</div>";
    }
}

$appointments = $aba->GetAppointmentsForUser($user['ID']);

?>
    <div id="main" class="container" style="background: white; border-radius: 6px; padding: 20px; margin-top: 20px;">

        <img src="/assets/img/appointment.png" width="100" style="float:right">

        <h1>Appointment Management</h1>
        <?
        if ($forUser) {
            echo "<h2>Appointment Listing for " . $user['FirstName'] . " " . $user['LastName'] . "</h2>";
        } else {
            echo "<h2>My Current Appointments</h2>";
        }
        ?>
        <br>
        <?php if (count($appointments) > 0) { ?>
            <table class="table table-striped">
                <?php
                echo "<tr>";
                foreach ($appointments[0] as $item => $value) {
                    echo "<th>$item</th>";
                }
                echo "<th>Eqmt.</th>";
                echo "<th>Action(s)</th>";
                echo "</tr>";

                foreach ($appointments as $item => $value) {
                    echo "<tr>";
                    foreach ($value as $field) {
                        echo "<td>$field</td>";
                    }

                    $userId = $user['ID'];
                    $appointmentId = $value['ID'];
                    $phpSelf = $_SERVER['PHP_SELF'];

                    $equipmentArray = array();
                    $equipmentRawArray = $aba->GetEquipmentForAppointment($value['ID']);
                    foreach($equipmentRawArray as $item)
                    {
                        array_push($equipmentArray, $item['Name']);
                    }
                    $equipmentList = implode("<br>", $equipmentArray);

                    if (!empty($equipmentList)) {
                        echo "<td><a href='#' data-toggle='tooltip' data-html=true data-placement='left' title='$equipmentList'><i class='fa fa-plus-square'></i></a></td>";
                    } else {echo "<td></td>";}

                    echo "<td>";

                    if (in_array($_SESSION['user']['Type_ID'], array(
                        AuthENUMS::ADMIN, AuthENUMS::SUPERVISOR ))) {

                        echo "<form style='display:inline;' method='GET' action='appointment_add_edit.php'>";
                        echo "<input type='hidden' name='forUser' value='$userId'>";
                        echo "<input type='hidden' name='action' value='edit'>";
                        echo "<input type='hidden' name='actionId' value='$appointmentId'>";
                        echo "<button class='btn btn-primary'><i class='fa fa-pencil'></i>&nbsp;Edit</button>";
                        echo "</form>&nbsp;";
                    }

                    echo "<form style='display:inline;' method='POST' action='$phpSelf'>";
                    echo "<input type='hidden' name='forUser' value='$userId'>";
                    echo "<input type='hidden' name='action' value='cancel'>";
                    echo "<input type='hidden' name='actionId' value='$appointmentId'>";
                    echo "<button class='btn btn-danger'><i class='fa fa-ban'></i>&nbsp;Cancel</button>";
                    echo "</form>";
                    echo "</tr>";
                }
                ?>
            </table>
        <?php } else {
            echo "<h3>No appointments returned.</h3>";
        } ?>
        <hr>
        <form method="post">
            <input type='hidden' name='forUser' value='<? echo $userId ?>'>
            <input type="submit" class="btn btn-link" value="Refresh">
        </form>

        <? if (in_array($_SESSION['user']['Type_ID'], array(
            AuthENUMS::ADMIN, AuthENUMS::SUPERVISOR, AuthENUMS::PATIENT))) { ?>

        <form method="GET" action="appointment_add_edit.php">
            <input type='hidden' name='forUser' value='<? echo $userId ?>'>
            <input type='hidden' name='action' value='add'>
            <button class="btn btn-primary"><i class='fa fa-calendar'></i>&nbsp;Create Appointment</button>
        </form>

        <? } ?>

        <br>
        <form method="get" action=patient_display.php style="display:inline">

            <input type="hidden" name="patientid" value="<? echo $patient['ID'] ?>">
            <button class="btn btn-primary" value="Back to Patient"><i class='fa fa-user'></i>&nbsp;Back to Patient</button>

        </form>

        <a href="index.php">
            <button class="btn btn-primary"><i class='fa fa-home'></i>&nbsp;Click here to Return to the Main Menu</button>
        </a>

    </div>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
<?php
include("shared/footer.php");
?>