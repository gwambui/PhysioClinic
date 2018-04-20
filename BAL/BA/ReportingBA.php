<?php

/**
 * Class reportingBA
 */
class reportingBA extends BaseBA
{
    /**
     * @var ReportingDA
     */
    private $da;

    /**
     * reportingBA constructor.
     */
    public function __construct()
    {
        $this->da = new ReportingDA;
    }

    /**
     * @return array
     */
    public function GetPatientSummaryReportData()
    {
        return $this->da->GetPatientSummaryReportData();
    }

    /**
     * @param $start
     * @param $end
     * @return array
     */
    public function GetNumberOfPatientsSeenReport($start, $end)
    {
        return $this->da->GetNumberOfPatientsSeenReport($start, $end);
    }

    /**
     * @param $start
     * @param $end
     * @return array
     */
    public function GetUnusedEquipmentReport($start, $end)
    {
        return $this->da->GetUnusedEquipmentReport($start, $end);
    }

    /**
     * @param $centid
     * @return array
     */
    public function GetPatientsSeenAtCenter($centid)
    {
        return $this->da->GetPatientsSeenAtCenter($centid);
    }

    /**
     * @param $centid
     * @return array
     */
    public function GetTherapistsAtCenter($centid)
    {
        return $this->da->GetTherapistsAtCenter($centid);
    }

    /**
     * @param $patientid
     * @return array
     */
    public function GetPatientAppointmentRecord($patientid)
    {
        return $this->da->GetPatientAppointmentRecord($patientid);
    }

    /**
     * @param $spID
     * @param $start
     * @param $end
     * @return array
     */
    public function GetTherapistAvailability($spID, $start, $end)
    {
        return $this->da->GetTherapistAvailability($spID,$start, $end);
    }

    /**
     * @param $patientid
     * @return array
     */
    public function GetPatientPrescriptionsRecord($patientid)
    {
        return $this->da->GetPatientPrescriptionsRecord($patientid);
    }

    /**
     * @return array
     */
    public function GetPatientsWithoutAppointments()
    {
        return $this->da->GetPatientsWithoutAppointments();
    }

    /**
     * @param $days
     * @param $frequency
     * @return array
     */
    public function GetEquipmentUseFrequency($days, $frequency)
    {
        return $this->da->GetEquipmentUseFrequency($days, $frequency);
    }

    /**
     * @param $lower
     * @param $upper
     * @return array
     */
    public function GetPatientsGroupedByAge($lower, $upper )
    {
        return $this->da->GetPatientsGroupedByAge($lower, $upper );
    }
}