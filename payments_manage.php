<?php
session_start();
require_once 'shared/access_validate.php';
require_once 'BAL/BA.php';

//Checking userType
if (!in_array($_SESSION['user']['Type_ID'], array(
    AuthENUMS::SUPERVISOR,
    AuthENUMS::ADMIN
)))
{
    header('Location: index.php');
}


include("shared/header.php");
include("shared/top_bar.php");

$post = $_SERVER['REQUEST_METHOD'] == 'POST' ? true : false;

$payba = new PaymentBA();
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

$Payments = $payba->GetPaymentsForUser($user['ID']);
?>

    <div id="main" class="container" style="background: white; border-radius: 6px; padding: 20px; margin-top: 20px;">
        <img src="/assets/img/money_logo.png" width="100" style="float:right">
        <h1>Payment Management</h1>
        <?
        if ($forUser) {
            echo "<h2>Payment Listing for " . $user['FirstName'] . " " . $user['LastName'] . "</h2>";
        } else {
            echo "<h2>My Current Payments</h2>";
        }
        ?>
        <br>
        <?php if (count($Payments) > 0) { ?>
            <table class="table table-striped">
                <?php
                echo "<tr>";
                foreach ($Payments[0] as $item => $value) {
                    echo "<th>$item</th>";
                }
                echo "<th>Action(s)</th>";
                echo "</tr>";

                foreach ($Payments as $item => $value) {
                    echo "<tr>";
                    foreach ($value as $field) {
                        echo "<td>$field</td>";
                    }

                    $userId = $user['ID'];
                    $PaymentId = $value['Payment_ID'];
                    $phpSelf = $_SERVER['PHP_SELF'];

                    echo "<td><form method='GET' action='payment_make.php'>";
                    echo "<input type='hidden' name='forUser' value='$userId'>";
                    echo "<input type='hidden' name='action' value='Make A Payment''>";
                    echo "<input type='hidden' name='actionId' value='$PaymentId'>";
                    echo "<button class='btn btn-primary' value='Make A Payment'><i class='fa fa-usd'></i>&nbsp;Make a Payment</button>";
                    echo "</form>";
                    echo "</tr>";
                }
                ?>
            </table>
        <?php } else {
            echo "<h3>Sorry, no Payments returned.</h3>";
        } ?>
        <hr>
        <form method="post">
            <input type='hidden' name='forUser' value='<? echo $userId ?>'>
            <input type="submit" class="btn btn-link" value="Refresh">
        </form>
        <br>
        <form action=patient_display.php style="display:inline">

            <input type="hidden" name="patientid" value="<? echo $patient['ID'] ?>">
            <button class="btn btn-primary"><i class='fa fa-user'></i>&nbsp;Back to Patient</button>

        </form>

        <a href="index.php">
            <button class="btn btn-primary"><i class='fa fa-home'></i>&nbsp;Click here to Return to the Main Menu</button>
        </a>
    </div>
<?php
include("shared/footer.php");
?>