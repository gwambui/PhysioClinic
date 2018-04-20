<?php

class PaymentDTO
{
    var $ID;
    var $Amount;
    var $BillingDateTime;
    var $PaymentMethod_ID;
    var $PaymentStatus_ID;
    var $Appointment_ID;

    /**
     * PaymentDTO constructor.
     * @param $ID
     * @param $Amount
     * @param $BillingDateTime
     * @param $PaymentMethod_ID
     * @param $PaymentStatus_ID
     * @param $Appointment_ID
     */
    public function __construct( $ID, $Amount, $BillingDateTime,  $PaymentMethod_ID, $PaymentStatus_ID, $Appointment_ID)
    {
        $this->ID =  $ID;
        $this->Amount = $Amount;
        $this->BillingDateTime = $BillingDateTime;
        $this->PaymentMethod_ID =  $PaymentMethod_ID;
        $this->PaymentStatus_ID = $PaymentStatus_ID;
        $this->Appointment_ID = $Appointment_ID;
    }


}