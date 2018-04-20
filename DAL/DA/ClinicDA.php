<?php


class ClinicDA extends BaseDA
{
    private $db;

    public function __construct()
    {
        $this->db = getDBInstance();
    }

    public function GetClinics()
    {
        return $this->db->GetArrayList("select * from Center;");
    }

    public function GetClinic($centerID)
    {
        $bindParm = array("ID"=>$centerID);

        return $this->db->GetArray("select * from Center where ID = :ID;", $bindParm);
    }
}