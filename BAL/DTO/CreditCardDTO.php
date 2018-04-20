<?php

class CreditCardDTO
{
    var $Payment_ID;
    var $Number;
    var $ExpiryDate;
    var $CVC;

    /**
     * CreditCardDTO constructor.
     * @param $Payment_ID
     * @param $Number
     * @param $ExpiryDate
     * @param $CVC
     */
    public function __construct( $Payment_ID, $Number, $ExpiryDate,  $CVC)
    {
        $this->Payment_ID =  $Payment_ID;
        $this->Number = $Number;
        $this->ExpiryDate = $ExpiryDate;
        $this->CVC =  $CVC;
    }


}