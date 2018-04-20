<?php

class ReportingDA extends BaseDA
{
    private $db;

    function __construct()
    {
        $this->db = getDBInstance();
    }

    public function GetPatientSummaryReportData()
    {
        return $this->db->GetArrayList("select * from Patient;");
    }

    public function GetNumberOfPatientsSeenReport($start, $end)
    {
        $startDateString = $start->format("Y-m-d H:i:s");
        $endDateString = $end->format("Y-m-d H:i:s");

        $bindParms = array("Start"=>$startDateString, "End"=>$endDateString);
        $rows =  $this->db->GetArrayList("call report1_NumPatientSeen(:Start, :End);", $bindParms);

        return $rows;
    }
    public function GetUnusedEquipmentReport($start,$end)
    {
        $startDateString = $start->format("Y-m-d H:i:s");
        $endDateString = $end->format("Y-m-d H:i:s");

        $bindParms = array("Start"=>$startDateString, "End"=>$endDateString);
        $rows = $this->db->GetArrayList("call report2_UnusedEquipment(:Start, :End);",$bindParms);

        return $rows;
    }
    public function GetPatientsSeenAtCenter($centerid)
    {

        $bindParms = array("ID"=>$centerid);
        $rows = $this->db->GetArrayList("call report3_PatientsSeenAtCenter(:ID);",$bindParms);
        return $rows;
    }
    public function GetTherapistsAtCenter($centerid)
    {

        $bindParms = array("ID"=>$centerid);
        $rows = $this->db->GetArrayList("call report4_TherapistAtCenter(:ID);",$bindParms);
        return $rows;
    }
    public function GetPatientAppointmentRecord($patientid)
    {

        $bindParms = array("ID"=>$patientid);
        $rows = $this->db->GetArrayList("call report6_PatientAppointments(:ID);",$bindParms);
        return $rows;
    }

    public function GetTherapistAvailability($spID,$start, $end)
    {
        $startDateString = $start->format("Y-m-d H:i:s");
        $endDateString = $end->format("Y-m-d H:i:s");
        $bindParms = array("ID" =>$spID, "Start"=>$startDateString, "End"=>$endDateString);
        $rows = $this->db->GetArrayList("call report7_DocAvailability(:ID, :Start, :End);",$bindParms);
        return $rows;
    }
    public function GetPatientPrescriptionsRecord($patientid)
    {

        $bindParms = array("ID"=>$patientid);
        $rows = $this->db->GetArrayList("call reportA_Patient(:ID);",$bindParms);
        return $rows;
    }
    public function GetPatientsWithoutAppointments()
    {
        $rows = $this->db->GetArrayList("call reportB_Doctor();");
        return $rows;
    }
    public function GetEquipmentUseFrequency($days, $frequency)
    {
        $bindParms = array("Days" =>$days, "Freq"=>$frequency);
        $rows = $this->db->GetArrayList("call reportC_Therapist(:Days, :Freq);",$bindParms);
        return $rows;
    }
    public function GetPatientsGroupedByAge($lower, $upper )
    {
        $bindParms = array("Upper" =>$upper, "Lower"=>$lower);
        $rows = $this->db->GetArrayList("call reportD_Receptionist(:Lower, :Upper);",$bindParms);
        return $rows;
    }


}