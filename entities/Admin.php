<?php

namespace entities;

class Admin
{
    private $admin_id;
    private $admin_name;
    private $admin_email;
    private $admin_pw;
    private $admin_address;
    private $admin_city;
    private $admin_profile;
    private $admin_status;

    /**
     * @return mixed
     */
    public function getAdminId()
    {
        return $this->admin_id;
    }

    /**
     * @param mixed $admin_id
     */
    public function setAdminId($admin_id)
    {
        $this->admin_id = $admin_id;
    }

    /**
     * @return mixed
     */
    public function getAdminName()
    {
        return $this->admin_name;
    }

    /**
     * @param mixed $admin_name
     */
    public function setAdminName($admin_name)
    {
        $this->admin_name = $admin_name;
    }

    /**
     * @return mixed
     */
    public function getAdminEmail()
    {
        return $this->admin_email;
    }

    /**
     * @param mixed $admin_email
     */
    public function setAdminEmail($admin_email)
    {
        $this->admin_email = $admin_email;
    }

    /**
     * @return mixed
     */
    public function getAdminPw()
    {
        return $this->admin_pw;
    }

    /**
     * @param mixed $admin_pw
     */
    public function setAdminPw($admin_pw)
    {
        $this->admin_pw = $admin_pw;
    }

    /**
     * @return mixed
     */
    public function getAdminAddress()
    {
        return $this->admin_address;
    }

    /**
     * @param mixed $admin_address
     */
    public function setAdminAddress($admin_address)
    {
        $this->admin_address = $admin_address;
    }

    /**
     * @return mixed
     */
    public function getAdminCity()
    {
        return $this->admin_city;
    }

    /**
     * @param mixed $admin_city
     */
    public function setAdminCity($admin_city)
    {
        $this->admin_city = $admin_city;
    }

    /**
     * @return mixed
     */
    public function getAdminProfile()
    {
        return $this->admin_profile;
    }

    /**
     * @param mixed $admin_profile
     */
    public function setAdminProfile($admin_profile)
    {
        $this->admin_profile = $admin_profile;
    }

    /**
     * @return mixed
     */
    public function getAdminStatus()
    {
        return $this->admin_status;
    }

    /**
     * @param mixed $admin_status
     */
    public function setAdminStatus($admin_status)
    {
        $this->admin_status = $admin_status;
    }


}