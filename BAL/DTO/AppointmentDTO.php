<?php

class AppointmentDTO
{
    var $id;
    var $Patient_ID;
    var $Prescription_ID;
    var $CreatedDateTime;
    var $StartDateTime;
    var $EndDateTime;
    var $Status_ID;

    /**
     * AppointmentDTO constructor.
     * @param $id
     * @param $Patient_ID
     * @param $Prescription_ID
     * @param $CreatedDateTime
     * @param $StartDateTime
     * @param $EndDateTime
     * @param $Status_ID
     */
    public function __construct($id, $Patient_ID, $Prescription_ID, $CreatedDateTime, $StartDateTime, $EndDateTime,
                                $Status_ID)
    {
        $this->id = $id;
        $this->Patient_ID = $Patient_ID;
        $this->Prescription_ID = $Prescription_ID;
        $this->CreatedDateTime = $CreatedDateTime;
        $this->StartDateTime = $StartDateTime;
        $this->EndDateTime = $EndDateTime;
        $this->Status_ID = $Status_ID;
    }


}