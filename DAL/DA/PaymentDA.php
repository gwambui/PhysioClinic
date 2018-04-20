<?php

/**
 * Class UserDA
 */
class PaymentDA extends BaseDA
{
    /**
     * @var MySqlPDO
     */
    private $db;

    /**
     * UserDA constructor.
     */
    function __construct()
    {
        $this->db = getDBInstance();
    }

    /**
     * @param $username
     * @return array
     */
    public function GetAuthorizations()
    {
        $authArray = $this->db->GetArrayList("select * from Patient;");

        $returnCSV = "header1, header2, header3\r\n";

        foreach ($authArray as $row)
        {
            $returnCSV = $returnCSV . implode(",",$row) . "\r\n";
        }

        return $returnCSV;
    }
    public function GetPayments($start=1, $take=9999)
    {
        return $this->db->GetArrayList("select * from v_Payments;");
    }

    public function GetPaymentsForUser($user)
    {
        $bindParms = array("User"=>$user);

        return $this->db->GetArrayList("CALL GetPayments(:User);", $bindParms);
    }

    public function GetPaymentById($id)
    {
        $bindParms = array("ID"=>$id);
        return $this->db->GetArray("select * from Payment where ID = :ID;", $bindParms);
    }

    public function GetPaymentMethod()
    {
        return $this->db->GetArrayList("select * from PaymentMethod;");
    }

    public function GetPaymentStatus()
    {
        return $this->db->GetArrayList("select * from PaymentStatus;");
    }

    public function GetAppointmentStartDateByPaymentId($id)
    {
        $bindParms = array("ID"=>$id);
        return $this->db->GetArray("select StartDateTime from Payment, Appointment where Payment.ID = :ID AND Payment.Appointment_ID = Appointment.ID;", $bindParms);
    }

    public function UpdatePayment(PaymentDTO $payD)
    {
        $bindParmsWhere = array("ID"=>$payD->ID);

        $bindParms = array (
            "PaymentMethod_ID"=>$payD->PaymentMethod_ID,
            "PaymentStatus_ID"=>$payD->PaymentStatus_ID
        );

        $this->db->UpdateData("Payment", $bindParms, "ID = ?", $bindParmsWhere);

        return true;
    }

    public function UpdatePaymentAmount(PaymentDTO $payD)
    {
        $bindParmsWhere = array("ID"=>$payD->ID);

        $bindParms = array (
            "Amount"=>$payD->Amount
        );

        $this->db->UpdateData("Payment", $bindParms, "ID = ?", $bindParmsWhere);

        return true;
    }

    public function AddCreditCardInfo(CreditCardDTO $ccD)
    {
        $bindParms = array (
            "Payment_ID"=>$ccD->Payment_ID,
            "Number"=>$ccD->Number,
            "ExpiryDate"=>$ccD->ExpiryDate,
            "CVC"=>$ccD->CVC
        );
        $this->db->InsertData("CreditCard", $bindParms);
        return $this->db->GetLastInsertId();
    }
}