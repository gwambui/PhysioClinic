<?php

class PrescriptionDA extends BaseDA
{
    private $db;

    public function __construct()
    {
        $this->db = getDBInstance();
    }

    public function GetPrescriptions($page, $quantity)
    {
        return $this->db->GetArrayList("select * from v_Prescriptions limit $page, $quantity;");
    }

    public function GetPrescriptionsForUserLookup($userId)
    {
        $bindParms = array("ID"=>$userId);

        return $this->db->GetArrayList("select pre.ID, pre.PrescriptionNumber, pre.Patient_ID, pre.IssuedByTrainer, pre.IssuedByLicence,pre.Specialist_ID, pre.Treatment_ID, t.Name as 'TreatmentName', pre.PrescriptionStatus_ID, pre.Notes from Prescription pre, Patient pat, Treatment t where pre.Treatment_ID = t.ID and pre.Patient_ID = pat.ID and pat.User_ID = :ID;", $bindParms);
    }

    public function GetPrescriptionsForUserFormatted($userId)
    {
        $bindParms = array("ID"=>$userId);
        return $this->db->GetArrayList("SELECT `v_PrescriptionList`.`ID`,`v_PrescriptionList`.`Prescription Number`,`v_PrescriptionList`.`Issued By Trainer`,`v_PrescriptionList`.`Trainer Licence`,`v_PrescriptionList`.`Specialist Name`,`v_PrescriptionList`.`Specialist License`,`v_PrescriptionList`.`Treatment Name`,`v_PrescriptionList`.`Status`,`v_PrescriptionList`.`Notes`FROM `ltc55311`.`v_PrescriptionList` WHERE Patient_User_ID = :ID;", $bindParms);
    }


    public function CancelPrescription($pid)
    {
        $bindParms = array("ID"=>$pid);

        $this->db->ExecuteNonQuery("update Prescription set PrescriptionStatus_ID = 2 where ID = :ID;", $bindParms);
    }

    public function AddPrescription(PrescriptionDTO $prescriptionDTO)
    {
        $bindParms = array(
            "PrescriptionNumber"=>$prescriptionDTO->PrescriptionNumber,
            "Patient_ID"=>$prescriptionDTO->PatientID,
            "IssuedByTrainer"=>$prescriptionDTO->IssuedByTrainer,
            "IssuedByLicence"=>$prescriptionDTO->IssuedByLicense,
            "Specialist_ID"=>$prescriptionDTO->SpecialistID,
            "Treatment_ID"=>$prescriptionDTO->TreatmentID,
            "PrescriptionStatus_ID"=>$prescriptionDTO->PrescriptionStatusID,
            "Notes"=>$prescriptionDTO->Notes);

        $this->db->InsertData("Prescription", $bindParms);

        return $this->db->GetLastInsertId();
    }

    public function ModifyPrescription(PrescriptionDTO $prescriptionDTO)
    {
        $bindParmsWhere = array("ID"=>$prescriptionDTO->ID);

        $bindParms = array(
            "PrescriptionNumber"=>$prescriptionDTO->PrescriptionNumber,
            "Patient_ID"=>$prescriptionDTO->PatientID,
            "IssuedByTrainer"=>$prescriptionDTO->IssuedByTrainer,
            "IssuedByLicence"=>$prescriptionDTO->IssuedByLicense,
            "Specialist_ID"=>$prescriptionDTO->SpecialistID,
            "Treatment_ID"=>$prescriptionDTO->TreatmentID,
            "PrescriptionStatus_ID"=>$prescriptionDTO->PrescriptionStatusID,
            "Notes"=>$prescriptionDTO->Notes);

        $this->db->UpdateData("Prescription", $bindParms, "ID = ?", $bindParmsWhere);

        return true;
    }

    public function GetPrescriptionById($prescriptionId)
    {
        $bindParms = array("ID"=>$prescriptionId);
        return $this->db->GetArray("select * from Prescription where ID = :ID", $bindParms);
    }
}