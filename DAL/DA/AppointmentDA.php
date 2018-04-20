<?php


class AppointmentDA extends BaseDA
{
    private $db;

    public function __construct()
    {
        $this->db = getDBInstance();
    }

    public function GetAppointments($start=1, $take=9999)
    {
        return $this->db->GetArrayList("select * from v_Appointments;");
    }

    public function GetAppointmentsForUser($user)
    {
        $bindParms = array("User"=>$user);

        return $this->db->GetArrayList("CALL GetAppointments(:User);", $bindParms);
    }

    public function GetAppointmentById($id)
    {
        $bindParms = array("ID"=>$id);
        return $this->db->GetArray("select * from Appointment where ID = :ID;", $bindParms);
    }

    public function AddAppointment(AppointmentDTO $a)
    {
        $bindParms = array (
            "Patient_ID"=>$a->Patient_ID,
            "Prescription_ID"=>$a->Prescription_ID,
            "Status_ID"=>$a->Status_ID,

            "CreatedDateTime"=>date_format($a->CreatedDateTime, "Y-m-d H:i:s"),
            "StartDateTime"=>date_format($a->StartDateTime, "Y-m-d H:i:s"),
            "EndDateTime"=>date_format($a->EndDateTime, "Y-m-d H:i:s")
        );

        $this->db->InsertData("Appointment", $bindParms);

        return $this->db->GetLastInsertId();
    }

    public function ModifyAppointment(AppointmentDTO $a)
    {
        $bindParmsWhere = array("ID"=>$a->id);

        $bindParms = array (
            "Prescription_ID"=>$a->Prescription_ID,
            "Status_ID"=>$a->Status_ID,
            "StartDateTime"=>date_format($a->StartDateTime, "Y-m-d H:i:s"),
            "EndDateTime"=>date_format($a->EndDateTime, "Y-m-d H:i:s")
        );

        $this->db->UpdateData("Appointment", $bindParms, "ID = ?", $bindParmsWhere);

        return true;
    }

    public function CancelAppointment($appointmentId)
    {
        $bindParms = array("ID"=>$appointmentId);

        $this->db->ExecuteNonQuery("update Appointment set Status_ID = 3 where ID = :ID;", $bindParms);
    }

    public function GetEquipmentList()
    {
        return $this->db->GetArrayList("select * from Equipment;");
    }

    public function AddEquipmentToAppointment($e, $a)
    {
        $bindparms = array("Appointment_ID"=>$a, "Equipment_ID"=>$e);
        $this->db->InsertData("Appointment_Equipment", $bindparms);
        return $this->db->GetLastInsertId();
    }

    public function ReplaceEquipmentToAppointment($e, $a)
    {
        $bindparms = array("Appointment_ID"=>$a, "Equipment_ID"=>$e);
        $this->db->ExecuteNonQuery("REPLACE into Appointment_Equipment (Appointment_ID, Equipment_ID) values (:Appointment_ID, :Equipment_ID);", $bindparms);
        return $this->db->GetLastInsertId();
    }

    public function GetEquipmentForAppointment($a)
    {
        $bindparms = array("AppID"=>$a);
        return $this->db->GetArrayList("select e.ID, e.Name from Appointment_Equipment ae, Equipment e where ae.Equipment_ID = e.ID and ae.Appointment_ID = :AppID", $bindparms);

    }

    public function GetAppointmentStatuses()
    {
        return $this->db->GetArrayList("select * from Appointment_Status;");
    }
}