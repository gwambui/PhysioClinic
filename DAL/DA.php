<?php

require_once 'DA/BaseDA.php';
require_once 'DA/UserDA.php';
require_once 'DA/ReportingDA.php';
require_once 'DA/PaymentDA.php';
require_once 'DA/PatientDA.php';
require_once 'DA/DoctorDA.php';
require_once 'DA/ClinicDA.php';
require_once 'DA/TreatmentDA.php';
require_once 'DA/PrescriptionDA.php';
require_once 'DA/AppointmentDA.php';
require_once 'DA/SpecialistDA.php';

require_once 'MySqlPDO/MySqlPDO.php';
require_once 'DbSettings.php';


function getDBInstance()
{
    $m = MySqlPDO::CreateNewInstance();
    
    $m->Connect(DB_NAME, DB_USER, DB_PASSWORD, DB_URL, DB_PORT);

    return $m;
}