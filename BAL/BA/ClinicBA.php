<?php

/**
 * Class ClinicBA
 */
class ClinicBA extends BaseBA
{
    /**
     * @var ClinicDA
     */
    private $cda;

    /**
     * ClinicBA constructor.
     */
    public function __construct()
    {
        $this->cda = new ClinicDA();
    }

    /**
     * @return array
     */
    public function GetClinics()
    {
        return $this->cda->GetClinics();
    }

    /**
     * @param $centerID
     * @return array
     */
    public function GetClinic($centerID)
    {
        return $this->cda->GetClinic($centerID);
    }
}