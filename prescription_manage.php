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

$post = $_SERVER['REQUEST_METHOD'] == 'POST' ? true : false;

$uba = new UserBA();
$prba = new PrescriptionBA();
$pba = new PatientBA();

if (!empty($_POST['forUser'])) {
    $forUser = $_POST['forUser'];
    $user = $uba->GetUserByID($forUser);
}

$userId = $user['ID'];
$action = $_POST['action'];
$actionId = $_POST['actionId'];

$patient = $pba->GetPatientByUserId($userId);

if ($action == 'cancel')
{
    try
    {
        $prba->CancelPrescription($actionId);
        echo "<script>alert('Prescription Modified.')</script>";
    }
    catch (PDOException $e)
    {
        echo "<div class='alert alert-danger alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Error! </strong>" . $e->getMessage() . "</div>";
    }
}

$prescriptions = $prba->GetPrescriptionsForUserFormatted($user['ID']);

?>
    <div id="main" class="container" style="background: white; border-radius: 6px; padding: 20px; margin-top: 20px;">

        <img src="/assets/img/prescription.png" width="100" style="float:right">

        <h1>Prescription Management</h1>
        <hr>

        <?
        if ($forUser)
        {
            echo "<h3>Prescriptions for ". $user['FirstName'] . " " . $user['LastName'] . "</h3>";
        }
        else
        {
            echo "<h2>No patient selected.</h2>";
        }

        ?>
        <br>
        <?php if(count($prescriptions) > 0) { ?>
            <table class="table table-striped">
                <?php
                echo "<tr>";
                foreach ($prescriptions[0] as $item => $value) {
                    echo "<th>$item</th>";
                }
                echo "<th>Action(s)</th>";
                echo "</tr>";

                foreach ($prescriptions as $item => $value) {
                    echo "<tr>";
                    foreach ($value as $field) {
                        echo "<td>$field</td>";
                    }

                    $userId = $user['ID'];
                    $prescriptionId = $value['ID'];
                    $phpSelf = $_SERVER['PHP_SELF'];

                    echo "<td width='230'>";

                    if (in_array($_SESSION['user']['Type_ID'], array(
                        AuthENUMS::ADMIN, AuthENUMS::DOCTOR, AuthENUMS::THERAPIST, AuthENUMS::SUPERVISOR))) {

                        echo "<form style='display:inline;' method='GET' action='prescription_add_edit.php'>";
                        echo "<input type='hidden' name='forUser' value='$userId'>";
                        echo "<input type='hidden' name='action' value='edit'>";
                        echo "<input type='hidden' name='actionId' value='$prescriptionId'>";
                        echo "<button class='btn btn-primary'><i class='fa fa-pencil'></i>&nbsp;Edit</button>";
                        echo "</form>&nbsp;";
                        echo "<form style='display:inline;' method='POST' action='$phpSelf'>";
                        echo "<input type='hidden' name='forUser' value='$userId'>";
                        echo "<input type='hidden' name='action' value='cancel'>";
                        echo "<input type='hidden' name='actionId' value='$prescriptionId'>";
                        echo "<button type='button' class='btn btn-danger'><i class='fa fa-ban'></i>&nbsp;Compl/Cancel</button>";
                        echo "</form>";
                    }
                    else
                    {
                        echo "None";
                    }


                    echo "</tr>";
                }
                ?>
            </table>
        <?php } else { echo "<h3>No prescriptions found.</h3>"; }  ?>
        <hr>
        <form method="post">
            <input type='hidden' name='forUser' value='<? echo $userId ?>'>
            <input type="submit" class="btn btn-link" value="Refresh">
        </form>

        <? if (in_array($_SESSION['user']['Type_ID'], array(
            AuthENUMS::ADMIN, AuthENUMS::SUPERVISOR, AuthENUMS::DOCTOR, AuthENUMS::THERAPIST))) { ?>

        <form method="GET" action="prescription_add_edit.php" >
            <input type='hidden' name='forUser' value='<? echo $userId ?>'>
            <input type='hidden' name='action' value='add'>
            <button class="btn btn-primary"><i class='fa fa-pencil-square-o'></i>&nbsp;Create Prescription</button>
        </form>

        <? } ?>

        <br>

        <form method="get" action = patient_display.php style="display:inline">

            <input type="hidden" name="patientid" value="<? echo $patient['ID'] ?>">
            <button class="btn btn-primary btn-sm"><i class='fa fa-user'></i>&nbsp;Back to Patient</button>

        </form>

        <a href="index.php"><button class="btn btn-primary btn-sm"><i class='fa fa-home'></i>&nbsp;Click here to Return to the Main Menu</button></a>

    </div>
<?php
include("shared/footer.php");
?>