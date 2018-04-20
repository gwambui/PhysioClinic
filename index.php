<?php/*/*
session_start();

require_once 'shared/access_validate.php';
include("shared/header.php");
require_once 'BAL/BA.php';
$uba = new UserBA;
$pageName = $_SERVER['PHP_SELF'] ;
$currentAccess = $uba->GetUserType($_SESSION['user']['Type_ID']);
var_dump($_SESSION);*/
?>

    <link href="/assets/css/index_styles.css" rel="stylesheet">

    <div class="container theme-showcase" role="main">
        <div class="jumbotron">
            <div align="center"  style="float:right">
                <img src="assets/img/bspc_bare_logo.png" width="182" height="170.5">
                <br><br>
                <a href="/assets/documents/project_ltc55311_summer2017.pdf" class="btn btn-info">Download Project Report</a>
                <br><br>
                <a href="/assets/documents/user_manual_ltc55311.pdf" class="btn btn-info">Download User Manual</a>
            </div>
            <h2><b><? /*echo $currentAccess */?>Home</b></h2>
            <p><? echo GetDailyMessage() . ", " . $_SESSION['user']['FirstName'] . " " . $_SESSION['user']['LastName'] ?></p>

            <h3>FUNCTIONS AVAILABLE</h3>
            <table border="1" cellpadding="10">
                <? if (in_array($_SESSION['user']['Type_ID'], array(
                    AuthENUMS::ADMIN,
                    AuthENUMS::SUPERVISOR))) { ?>
                <tr>
                    <td width="250px"><b>NEW PATIENT</b><br>Create a new patient record and login.</td>
                    <td width="500px"><a href='patient_add.php'>
                            <button class='btn btn-primary'><i class='fa fa-user-plus'></i>&nbsp;Register a New Patient</button>
                        </a></td>
                </tr>
                <? } ?>
                <? if (in_array($_SESSION['user']['Type_ID'], array(
                    AuthENUMS::ADMIN,
                    AuthENUMS::SUPERVISOR,
                    AuthENUMS::DOCTOR,
                    AuthENUMS::THERAPIST))) { ?>
                <tr>
                    <td><b>PATIENT SEARCH</b><br>Search for an existing patient here.<br><i>First and last names will be
                            searched.</i></td>
                    <td>
                        <form name="searchform" action="" method="post" onsubmit="">
                            <input class="form-control" type="text" name="q" class="inputTextSearchBox" id="livesearch"
                                   onkeyup="searchIt()" onblur="if (this.value == '') {this.value = 'Search..';}"
                                   onfocus="if(this.value == 'Search..') {this.value = '';}" value="Search.."
                                   onKeyPress="return disableEnterKey(event)"/>
                        </form>
                        <div id="LSResult" style="display: none;"></div>
                    </td>
                </tr>
                <? } ?>
                <? if (in_array($_SESSION['user']['Type_ID'], array(
                        AuthENUMS::PATIENT,
                        AuthENUMS::SUPERVISOR))) { ?>
                <tr>
                    <td width="250px"><b>REQUEST APPOINTMENT</b><br>Schedule a new appointment.</td>
                    <td width="500px"><a href='appointment_manage.php'>
                            <button class='btn btn-primary'><i class='fa fa-calendar'></i>&nbsp;Request Appointment</button>
                        </a></td>
                </tr>
                <? } ?>
                <? if (in_array($_SESSION['user']['Type_ID'], array(
                    AuthENUMS::SUPERVISOR,
                    AuthENUMS::DOCTOR,
                    AuthENUMS::THERAPIST
                ))) { ?>
                <tr>
                    <td width="250px"><b>WRITE PRESCRIPTION</b><br>Create a new prescription.</td>
                    <td width="500px"><a href='prescription_manage.php'>
                            <button class='btn btn-primary'><i class='fa fa-pencil-square-o'></i>&nbsp;New Prescription</button>
                        </a></td>
                </tr>
                <? } ?>
            </table>
        </div>
    </div>

    <script>
        function searchIt() {
            var inputValue = $('#livesearch').delay(100).val();
            var linkResult = "live_search.php?q=" + encodeURIComponent(inputValue);

            if ((inputValue != '') && (inputValue != ' ')) {
                $('#LSResult').load(linkResult);
                $('#LSResult').show(100);
            } else {
                $('#LSResult').load(linkResult);
                $('#LSResult').hide(100);
            }
        }

        // Disabling form submission by enter key
        function disableEnterKey(e) {
            var key;

            if (window.event)
                key = window.event.keyCode;     //IE
            else
                key = e.which;     //firefox

            if (key == 13)
                return false;
            else
                return true;
        }

    </script>

<?php include("shared/top_bar.php"); ?>
<?php include("shared/footer.php"); ?>