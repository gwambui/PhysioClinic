<?php

class PrescriptionDTO
{
    var $ID;
    var $PrescriptionNumber;
    var $PatientID;
    var $IssuedByTrainer;
    var $IssuedByLicense;
    var $SpecialistID;
    var $TreatmentID;
    var $PrescriptionStatusID;
    var $Notes;

    /**
     * PrescriptionDTO constructor.
     * @param $ID
     * @param $PrescriptionNumber
     * @param $PatientID
     * @param $IssuedByTrainer
     * @param $IssuedByLicense
     * @param $SpecialistID
     * @param $TreatmentID
     * @param $PrescriptionStatusID
     * @param $Notes
     */
    public function __construct($ID, $PrescriptionNumber, $PatientID, $IssuedByTrainer, $IssuedByLicense, $SpecialistID, $TreatmentID, $PrescriptionStatusID, $Notes)
    {
        $this->ID = $ID;
        $this->PrescriptionNumber = $PrescriptionNumber;
        $this->PatientID = $PatientID;
        $this->IssuedByTrainer = $IssuedByTrainer;
        $this->IssuedByLicense = $IssuedByLicense;
        $this->SpecialistID = $SpecialistID;
        $this->TreatmentID = $TreatmentID;
        $this->PrescriptionStatusID = $PrescriptionStatusID;
        $this->Notes = $Notes;
    }


}