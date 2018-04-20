<?php

class UserDA extends BaseDA
{
    private $db;

    function __construct()
    {
        $this->db = getDBInstance();
    }

    public function GetUser($username)
    {
        $bindParms = array('LoginID'=>$username);
        return $this->db->GetArray("select * from User where LoginID = :LoginID;",$bindParms);
    }

    public function GetUserByID($id)
    {
        $bindParms = array('ID'=>$id);

        return $this->db->GetArray("select * from User where ID = :ID;",$bindParms);
    }

    public function GetUserType($userTypeCode)
    {
        $bindParms = array('ID' => $userTypeCode);
        return $this->db->GetScaler("select Description from UserType where ID = :ID;", $bindParms);
    }

    public function AddUser(PatientAddDTO $user)
    {
        // Encrypt the password before saving it.
        $pass = password_hash($user->Password, PASSWORD_DEFAULT);

        $bindParms = array("LoginID"=>$user->LoginID, "FirstName"=>$user->FirstName, "LastName"=>$user->LastName, "Password"=>$pass, "Type_ID"=>2);

        $this->db->InsertData("User", $bindParms);

        // Return the last updated ID.
        return $this->db->GetLastInsertId();
    }
}