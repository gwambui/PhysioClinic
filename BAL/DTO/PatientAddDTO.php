<?php

class PatientAddDTO
{
    var $ID;

    var $BirthDate;
    var $PhoneNumber;
    var $User_ID;

    var $LoginID;
    var $FirstName;
    var $LastName;
    var $Password;
    var $Type_ID;

    /**
     * PatientAddDTO constructor.
     * @param $ID
     * @param $BirthDate
     * @param $PhoneNumber
     * @param $User_ID
     * @param $LoginID
     * @param $FirstName
     * @param $LastName
     * @param $Password
     * @param $Type_ID
     */
    public function __construct($ID, $BirthDate, $PhoneNumber, $InitialPrescription_ID, $User_ID, $LoginID, $FirstName, $LastName, $Password, $Type_ID)
    {
        $this->ID = $ID;
        $this->BirthDate = $BirthDate;
        $this->PhoneNumber = $PhoneNumber;
        $this->User_ID = $User_ID;
        $this->LoginID = $LoginID;
        $this->FirstName = $FirstName;
        $this->LastName = $LastName;
        $this->Password = $Password;
        $this->Type_ID = $Type_ID;
    }
}
