<?php

class PatientDA extends BaseDA
{
    private $db;

    public function __construct()
    {
        $this->db = getDBInstance();
    }

    public function AddPatient(PatientAddDTO $patient)
    {
        $date = date_create($patient->BirthDate);

        $data = array(
            "BirthDate"=>date_format($date, "Y-m-d"),
            "PhoneNumber"=>$patient->PhoneNumber,
            "User_ID"=>$patient->User_ID);

        $this->db->InsertData("Patient", $data);

        return $this->db->GetLastInsertId();
    }

    public function GetPatient($id)
    {
        $parms = array("p_id"=>$id);
        return $this->db->GetArray("select p.ID as PatientId, BirthDate, PhoneNumber, User_ID,u.ID, LoginID, FirstName, LastName, Password, Type_ID from Patient p, User u where p.User_ID = u.ID  and p.ID = :p_id", $parms);
    }

    public function GetPatientByUserId($id)
    {
        $bindParms = array("ID"=>$id);
        return $this->db->GetArray("select * from Patient p where p.User_ID = :ID", $bindParms);
    }

    public function SearchPatient($string, $type)
    {
        $string = "%" . $string . "%";

        $bindParms = array('string'=>$string, 'type'=>$type);

        return $this->db->GetArrayList(
            "select p.ID as 'PatientID', BirthDate, PhoneNumber, User_ID, LoginID, FirstName, LastName" .
            " from Patient p, User u where p.User_ID = u.ID and" .
            " (u.FirstName like :string or u.LastName like :string or p.ID like :string) and Type_ID = :type limit 5;",$bindParms);
    }
    public function GetPatients()
    {
        return $this->db->GetArrayList("select ID from Patient;");
    }
}