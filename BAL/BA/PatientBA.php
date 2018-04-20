<?php

/**
 * Class PatientBA
 */
class PatientBA extends BaseBA
{
    /**
     * @var PatientDA
     */
    private $pda;
    /**
     * @var UserDA
     */
    private $uda;

    /**
     * PatientBA constructor.
     */
    public function __construct()
    {
        $this->pda = new PatientDA();
        $this->uda = new UserDA();
    }

    /**
     * @param PatientAddDTO $patient
     * @return string
     */
    public function AddPatient(PatientAddDTO $patient)
    {
        try
        {
            $patient->User_ID = $this->uda->AddUser($patient);
            $patient->ID = $this->pda->AddPatient($patient);
            return $patient->ID;
        }
        catch (PDOException $pex)
        {
            throw new PDOException($pex);
        }
    }

    /**
     * @param $patientId
     * @return array
     */
    public function GetPatient($patientId)
    {
        return $this->pda->GetPatient($patientId);
    }

    /**
     * @param $userId
     * @return array
     */
    public function GetPatientByUserId($userId)
    {
        return $this->pda->GetPatientByUserId($userId);
    }

    /**
     * @return array
     */
    public function GetPatients()
    {
        return $this->pda->GetPatients();
    }
}