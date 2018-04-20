<?php
class SpecialistDA extends BaseDA
{
    private $db;

    public function __construct()
    {
    $this->db = getDBInstance();
    }

    public function GetSpecialists()
    {
    return $this->db->GetArrayList("select * from v_Specialist;");
    }

    public function GetSpecialist($specialistID)
    {
    $bindParm = array("ID"=>$specialistID);

    return $this->db->GetArray("select * from Specialist where ID = :ID;", $bindParm);
    }
}