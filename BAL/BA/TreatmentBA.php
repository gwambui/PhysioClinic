<?php

/**
 * Class TreatmentBA
 */
class TreatmentBA extends BaseBA
{
    /**
     * @return array
     */
    public function GetTreatments()
    {
        $cda = new TreatmentDA();

        return $cda->GetTreatments();
    }
}