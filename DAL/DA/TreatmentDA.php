<?php

class TreatmentDA extends BaseDA
{
    private $db;

    public function __construct()
    {
        $this->db = getDBInstance();
    }

    public function GetTreatments()
    {
        return $this->db->GetArrayList("select * from Treatment;");
    }
}