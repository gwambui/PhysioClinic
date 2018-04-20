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

$payba = new PaymentBA();

$action = null;
$userId = null;
$PaymentId = null;

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
    $PaymentId = $_GET['actionId'];

if (!empty($_POST['actionId']))
    $PaymentId = $_POST['actionId'];

// For updates.
if (!is_null($PaymentId))
{
    $currentPayment = $payba->GetPaymentById($PaymentId);
    $currentPaymentBillingDate = DateTime::createFromFormat("Y-m-d H:i:s", $currentPayment['BillingDateTime']);
    $currentPaymentInfo = $payba->GetAppointmentStartDateByPaymentId($PaymentId);
    $currentAppointmentStartDateTime = DateTime::createFromFormat("Y-m-d H:i:s", $currentPaymentInfo['StartDateTime']);
}
$paymentMethodLookup = $payba->GetPaymentMethod();
$paymentStatusLookup = $payba->GetPaymentStatus();

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

        <img src="/assets/img/money_logo.png" width="100" style="float:right">
        <form class="form-horizontal" method="post" action="<? echo $self; ?>">
            <h1><? ?></h1>
            <div id="payment_info" class="row">
                <div class="col-md-5 col-sm-5">
                    <h2><? echo $action == "update" ? "Update" : "Make"; ?> A Payment</h2>
                    <div class="form-group">
                        <label for="bill_datetime" class="col-sm-3 control-label">Billing Date and time</label>
                        <div class="col-sm-6">
                            <input <? echo $post ? "disabled='disabled'" : ""; ?> type="datetime-local"
                                                                                  id="bill_datetime"
                                                                                  name="bill_datetime"
                                                                                  class="form-control date"
                                                                                  autofocus
                                                                                  value="<?
                                                                                  echo !$currentPaymentBillingDate
                                                                                      ? ""
                                                                                      : date_format($currentPaymentBillingDate,
                                                                                          "Y-m-d\TH:i"); ?>"
                            <!-- 1985-04-12T23:20 -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="appStart_datetime" class="col-sm-3 control-label">Appointment Start Date and time</label>
                        <div class="col-sm-6">
                            <input <? echo $post ? "disabled='disabled'" : ""; ?> type="datetime-local"
                                                                                  id="appStart_datetime"
                                                                                  name="appStart_datetime"
                                                                                  class="form-control date"
                                                                                  autofocus
                                                                                  value="<?
                                                                                  echo !$currentAppointmentStartDateTime
                                                                                      ? ""
                                                                                      : date_format($currentAppointmentStartDateTime,
                                                                                          "Y-m-d\TH:i"); ?>"
                            <!-- 1985-04-12T23:20 -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="amount" class="col-sm-3 control-label">Enter Amount of the Payment</label>
                        <div class="col-sm-6">
                            <input <? echo $post ? "disabled='disabled'" : ""; ?> type="text" id="amount"
                                                                                  name="amount"
                                                                                  placeholder="Entering amount"
                                                                                  class="form-control"
                                                                                  value="<? echo !empty($currentPayment) ? $currentPayment['Amount'] : "";  ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="payment_receptionist" class="col-sm-3 control-label">Select Payment Method</label>
                        <div class="col-sm-6">

                            <select class="form-control"
                                    name="paymentMethod" <? echo $post ? "disabled='disabled'" : ""; ?>>
                                <?
                                foreach ($clinicLookup as $item => $value) {




                                    echo "<option " . ($isSelected ? "selected" : "") .  " value=" . $value['ID']  . ">" . $value['Name'] . "</option>";


                                } ?>
                                <?
                                echo "<option value='' ></option>";
                                foreach ($paymentMethodLookup as $item => $value) {

                                    $selected = $currentPayment['PaymentMethod_ID'] == $value['ID'] ? "selected" : "";

                                    echo "<option $selected value=" . $value['ID'] . ">" . $value['ID'] . " (" . $value['Name'] . ")" . "</option>";
                                    if ($selected =='4')
                                    {
                                        $isSelected = $_POST['centerID'] == $value['ID'];
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="payment_receptionist" class="col-sm-3 control-label">Select Payment Status</label>
                        <div class="col-sm-6">

                            <select class="form-control"
                                    name="paymentStatus" <? echo $post ? "disabled='disabled'" : ""; ?>>
                                <?
                                echo "<option value='' ></option>";
                                foreach ($paymentStatusLookup as $item => $value) {

                                    $selected = $currentPayment['PaymentStatus_ID'] == $value['ID'] ? "selected" : "";

                                    echo "<option $selected value=" . $value['ID'] . ">" . $value['ID'] . " (" . $value['Name'] . ")" . "</option>";
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-sm-5">
                    <h2><? echo $action == "add" ? "Add" : "Enter"; ?> the Credit Card information If pay with a Credit Card</h2>
                    <div class="form-group">
                        <label for="Payment_ID" class="col-sm-3 control-label">Payment_ID</label>
                        <div class="col-sm-6">
                            <input <? echo $post ? "disabled='disabled'" : ""; ?> type="text" id="Payment_ID"
                                                                                  name="Payment_ID"
                                                                                  placeholder="Entering Payment_ID"
                                                                                  class="form-control"
                                                                                  value="<? echo !empty($currentPayment) ? $currentPayment['ID'] : "";  ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="number" class="col-sm-3 control-label">Credit Card Number</label>
                        <div class="col-sm-6">
                            <input <? echo $post ? "disabled='disabled'" : ""; ?> type="text" id="number"
                                                                                  name="number"
                                                                                  placeholder="Entering Card Number"
                                                                                  class="form-control"
                                                                                  autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cc_expiryDate" class="col-sm-3 control-label">Expiry Date</label>
                        <div class="col-sm-6">
                            <input <? echo $post ? "disabled='disabled'" : ""; ?> type="text"
                                                                                  id="cc_expiryDate"
                                                                                  name="cc_expiryDate"
                                                                                  placeholder="Expiry Date (mm/yy)"
                                                                                  class="form-control date"
                                                                                  autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cvc" class="col-sm-3 control-label">CVC Number</label>
                        <div class="col-sm-6">
                            <input <? echo $post ? "disabled='disabled'" : ""; ?> type="text" id="cvc"
                                                                                  name="cvc"
                                                                                  placeholder="Entering CVC number (3 digits)"
                                                                                  class="form-control"
                                                                                  autofocus>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-sm-3">
                <input type="hidden" name="action" value="<? echo $action; ?>">
                <input type="hidden" name="forUser" value="<? echo $userId; ?>">
                <input type="hidden" name="actionId" value="<? echo $PaymentId; ?>">
                <button <? echo $post ? "disabled='disabled'" : ""; ?> type="submit" class="btn btn-success btn-block">
                    SAVE
                </button>
            </div>
        </form>

        <form action="payments_manage.php" method="post">
            <input type="hidden" name="forUser" value="<? echo $userId ?>">
            <input type="submit" value="Back to Payment Management" class="btn btn-primary" >
        </form>
    </div>

<? if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>

    <style type="text/css">#main {
            disabled: true;
        }</style>

    <div class="container" style="background: white; border-radius: 6px; padding: 20px; margin-top: 20px;">

        <?

        // Posted values
        $paymentAmount = $_POST['amount'];
        $paymentMethodId = $_POST['paymentMethod'];
        $paymentStatusId = $_POST['paymentStatus'];

        $ccNumber = $_POST['number'];
        $ccExpiryDate = $_POST['cc_expiryDate'];
        $ccCVC = $_POST['cvc'];

        try {

            $paymentDTO = new PaymentDTO($PaymentId,  $paymentAmount, '2017-08-03 01:50:00', // dummy billing time, they won't be updated!!
                $paymentMethodId, $paymentStatusId, 10001); // dummy Appointment_ID, it won't be updated!!
            $ccDTO = new CreditCardDTO($PaymentId,  $ccNumber, $ccExpiryDate, $ccCVC);

            if ($action == "Make A Payment") {
                $payba->UpdatePayment($paymentDTO);
                $payba->UpdatePaymentAmount($paymentDTO);
                if($paymentMethodId=='4'){
                    $payba->AddCreditCardInfo($ccDTO);
                    echo '<div class="alert alert-success"><p>Payment with Credit Card Successfully Processed.</p></div>';
                }else{
                    echo '<div class="alert alert-success"><p>Payment Successfully Processed.</p></div>';
                }
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