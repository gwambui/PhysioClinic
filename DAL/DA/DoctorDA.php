<?php

class DoctorDA extends BaseDA
{
    private $db;

    public function __construct()
    {
        $this->db = getDBInstance();
    }

    public function GetDoctors()
    {
        return $this->db->GetArrayList("select 
                e.ID as 'EmployeeID', e.Center_ID, e.EmployeeType_ID, e.User_ID,
                u.ID as 'UserId', u.LoginID, u.FirstName, u.LastName, u.Type_ID,
                ut.ID as 'UserTypeId', ut.Description
                from Employee e, User u, UserType ut
                where e.User_ID = u.ID
                and
                u.Type_ID = ut.ID
                and ut.Description = 'Doctor'");
    }
}