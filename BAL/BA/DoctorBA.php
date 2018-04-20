<?php

/**
 * Class DoctorBA
 */
class DoctorBA extends BaseBA
{
    /**
     * @var DoctorDA
     */
    private $dda;

    /**
     * DoctorBA constructor.
     */
    public function __construct()
    {
        $this->dda = new DoctorDA();
    }

    /**
     * @return array
     */
    public function GetDoctors()
    {
        return $this->dda->GetDoctors();
    }
}