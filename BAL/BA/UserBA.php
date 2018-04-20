<?php

/**
 * Class UserBA
 */
class UserBA extends BaseBA
{
    /**
     * @var UserDA
     */
    private $uda;

    /**
     * UserBA constructor.
     */
    public function __construct()
    {
        $this->uda = new UserDA();
    }

    /**
     * @param $userID
     * @return array
     */
    public function GetUser($userID)
    {
        try
        {
            return $this->uda->GetUser($userID);
        }
        catch (PDOException $pex)
        {
            throw new PDOException($pex);
        }
    }

    /**
     * @param $id
     * @return array
     */
    public function GetUserByID($id)
    {
        try
        {
            return $this->uda->GetUserByID($id);
        }
        catch (PDOException $pex)
        {
            throw new PDOException($pex);
        }
    }

    /**
     * @param $userTypeCode
     * @return null|string
     */
    public function GetUserType($userTypeCode)
    {
        try
        {
            return $this->uda->GetUserType($userTypeCode);
        }
        catch (PDOException $pex)
        {
            throw new PDOException($pex);
        }
    }

    /**
     * @param PatientAddDTO $user
     * @return string
     */
    public function AddUser(PatientAddDTO $user)
    {
        try
        {
            return $this->uda->AddUser($user);
        }
        catch (PDOException $pex)
        {
            throw new PDOException($pex);
        }
    }
}