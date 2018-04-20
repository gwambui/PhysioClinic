<?php

/**
 * Class PrescriptionBA
 */
class PrescriptionBA extends BaseBA
{
    /**
     * @var PrescriptionDA
     */
    private $prda;

    /**
     * PrescriptionBA constructor.
     */
    public function __construct()
    {
        $this->prda = new PrescriptionDA();
    }

    /**
     * @param PrescriptionDTO $prescription
     * @return string
     */
    public function AddPrescription(PrescriptionDTO $prescription)
    {
        return $this->prda->AddPrescription($prescription);
    }

    /**
     * @param PrescriptionDTO $prescriptionDTO
     * @return bool
     */
    public function ModifyPrescription(PrescriptionDTO $prescriptionDTO)
    {
        return $this->prda->ModifyPrescription($prescriptionDTO);
    }

    /**
     * @param $page
     * @param $quantity
     * @return array
     */
    public function GetPrescriptions($page, $quantity)
    {
        return $this->prda->GetPrescriptions($page, $quantity);
    }

    /**
     * @param $userId
     * @return array
     */
    public function GetPrescriptionsForUser($userId)
    {
        return $this->prda->GetPrescriptionsForUserLookup($userId);
    }

    /**
     * @param $userId
     * @return array
     */
    public function GetPrescriptionsForUserFormatted($userId)
    {
        return $this->prda->GetPrescriptionsForUserFormatted($userId);
    }

    /**
     * @param $prescriptionId
     */
    public function CancelPrescription($prescriptionId)
    {
        $this->prda->CancelPrescription($prescriptionId);
    }

    /**
     * @param $prescriptionId
     * @return array
     */
    public function GetPrescriptionById($prescriptionId)
    {
        return $this->prda->GetPrescriptionById($prescriptionId);
    }
}