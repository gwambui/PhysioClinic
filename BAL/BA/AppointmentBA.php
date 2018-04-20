<?php

require_once 'DAL/DA.php';

class AppointmentBA extends BaseBA
{
    /**
     * @var AppointmentDA
     */
    private $ada;

    /**
     * AppointmentBA constructor.
     */
    public function __construct()
    {
        $this->ada = new AppointmentDA();
    }

    /**
     * @param $start
     * @param $take
     * @return array
     */
    public function GetAppointments($start, $take)
    {
        return $this->ada->GetAppointments($start, $take);
    }

    /**
     * @param $user
     * @return array
     */
    public function GetAppointmentsForUser($user)
    {
        return $this->ada->GetAppointmentsForUser($user);
    }

    /**
     * @param $id
     * @return array
     */
    public function GetAppointmentById($id)
    {
        return $this->ada->GetAppointmentById($id);
    }

    /**
     * @param AppointmentDTO $a
     * @return string
     */
    public function AddAppointment(AppointmentDTO $a)
    {
        return $this->ada->AddAppointment($a);
    }

    /**
     * @param AppointmentDTO $a
     * @return bool
     */
    public function ModifyAppointment(AppointmentDTO $a)
    {
        return $this->ada->ModifyAppointment($a);
    }

    /**
     * @param $appointmentId
     */
    public function CancelAppointment($appointmentId)
    {
        $this->ada->CancelAppointment($appointmentId);
    }

    /**
     * @return array
     */
    public function GetEquipmentList()
    {
        return $this->ada->GetEquipmentList();
    }

    /**
     * @param $e
     * @param $a
     * @return string
     */
    public function AddEquipmentToAppointment($e, $a)
    {
        return $this->ada->AddEquipmentToAppointment($e, $a);
    }

    /**
     * @param $a
     * @return array
     */
    public function GetEquipmentForAppointment($a)
    {
        return $this->ada->GetEquipmentForAppointment($a);
    }

    /**
     * @param $e
     * @param $a
     * @return string
     */
    public function ReplaceEquipmentToAppointment($e, $a)
    {
        return $this->ada->ReplaceEquipmentToAppointment($e, $a);
    }


    /**
     * @param $a
     * @return array
     */
    public function GetAppointmentStatuses()
    {
        return $this->ada->GetAppointmentStatuses();
    }
}