<?php

namespace entities;

class Staff
{
    private $staff_id;
    private $staff_pw;
    private $staff_name;
    private $staff_email;
    private $staff_address;
    private $staff_profile;

    /**
     * @return mixed
     */
    public function getStaffProfile()
    {
        return $this->staff_profile;
    }

    /**
     * @param mixed $staff_profile
     */
    public function setStaffProfile($staff_profile): void
    {
        $this->staff_profile = $staff_profile;
    }

    /**
     * @return mixed
     */
    public function getStaffId()
    {
        return $this->staff_id;
    }

    /**
     * @param mixed $staff_id
     */
    public function setStaffId($staff_id)
    {
        $this->staff_id = $staff_id;
    }

    /**
     * @return mixed
     */
    public function getStaffPw()
    {
        return $this->staff_pw;
    }

    /**
     * @param mixed $staff_pw
     */
    public function setStaffPw($staff_pw)
    {
        $this->staff_pw = $staff_pw;
    }

    /**
     * @return mixed
     */
    public function getStaffName()
    {
        return $this->staff_name;
    }

    /**
     * @param mixed $staff_name
     */
    public function setStaffName($staff_name)
    {
        $this->staff_name = $staff_name;
    }

    /**
     * @return mixed
     */
    public function getStaffEmail()
    {
        return $this->staff_email;
    }

    /**
     * @param mixed $staff_email
     */
    public function setStaffEmail($staff_email)
    {
        $this->staff_email = $staff_email;
    }

    /**
     * @return mixed
     */
    public function getStaffAddress()
    {
        return $this->staff_address;
    }

    /**
     * @param mixed $staff_address
     */
    public function setStaffAddress($staff_address)
    {
        $this->staff_address = $staff_address;
    }

}