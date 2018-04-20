<?php

require_once 'DAL/DA.php';

class paymentBA extends BaseBA
{
    private $pda;

    public function __construct()
    {
        $this->pda = new PaymentDA();
    }

    public function getAuthorizations()
    {
        return $this->pda->GetAuthorizations();
    }

    public function updatePaymentsAllSuccess()
    {}

    public function GetPayments($start, $take)
    {
        return $this->pda->GetPayments($start, $take);
    }

    public function GetPaymentsForUser($user)
    {
        return $this->pda->GetPaymentsForUser($user);
    }

    public function GetPaymentById($id)
    {
        return $this->pda->GetPaymentById($id);
    }

    public function GetAppointmentStartDateByPaymentId($id)
    {
        return $this->pda->GetAppointmentStartDateByPaymentId($id);
    }

    public function GetPaymentMethod()
    {
        return $this->pda->GetPaymentMethod();
    }

    public function GetPaymentStatus()
    {
        return $this->pda->GetPaymentStatus();
    }

    public function UpdatePayment(PaymentDTO $payD)
    {
        return $this->pda->UpdatePayment($payD);
    }

    public function UpdatePaymentAmount(PaymentDTO $payD)
    {
        return $this->pda->UpdatePaymentAmount($payD);
    }

    public function AddCreditCardInfo(CreditCardDTO $ccD)
    {
        return $this->pda->AddCreditCardInfo($ccD);
    }
}