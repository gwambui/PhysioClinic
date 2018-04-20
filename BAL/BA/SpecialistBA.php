<?php

/**
 * Class SpecialistBA
 */
class SpecialistBA extends BaseBA
{
    /**
     * @var SpecialistDA
     */
    private $sda;

    /**
     * SpecialistBA constructor.
     */
    public function __construct()
    {
        $this->sda = new SpecialistDA();
    }

    /**
     * @return array
     */
    public function GetSpecialists()
    {
        return $this->sda->GetSpecialists();
    }

    /**
     * @param $specialistID
     * @return array
     */
    public function GetSpecialist($specialistID)
    {
        return $this->sda->GetSpecialist($specialistID);
    }
}