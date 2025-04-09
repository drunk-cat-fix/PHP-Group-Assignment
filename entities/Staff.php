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
    private $vendor_name;
    private $vendor_desc;
    private $shop_name;
    private $shop_address;
    private $shop_city;
    private $shop_state;
    private $vendor_profile;
    private $vendor_email;

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

    // Getter and Setter for Vendor Name
    public function getVendorName()
    {
        return $this->vendor_name;
    }

    public function setVendorName($vendor_name)
    {
        $this->vendor_name = $vendor_name;
    }

    // Getter and Setter for Vendor Description
    public function getVendorDesc()
    {
        return $this->vendor_desc;
    }

    public function setVendorDesc($vendor_desc)
    {
        $this->vendor_desc = $vendor_desc;
    }

    // Getter and Setter for Shop Name
    public function getShopName()
    {
        return $this->shop_name;
    }

    public function setShopName($shop_name)
    {
        $this->shop_name = $shop_name;
    }

    // Getter and Setter for Shop Address
    public function getShopAddress()
    {
        return $this->shop_address;
    }

    public function setShopAddress($shop_address)
    {
        $this->shop_address = $shop_address;
    }

    // Getter and Setter for Shop City
    public function getShopCity()
    {
        return $this->shop_city;
    }

    public function setShopCity($shop_city)
    {
        $this->shop_city = $shop_city;
    }

    // Getter and Setter for Shop State
    public function getShopState()
    {
        return $this->shop_state;
    }

    public function setShopState($shop_state)
    {
        $this->shop_state = $shop_state;
    }

    // Getter and Setter for Vendor Profile
    public function getVendorProfile()
    {
        return $this->vendor_profile;
    }

    public function setVendorProfile($vendor_profile)
    {
        $this->vendor_profile = $vendor_profile;
    }

    // Getter and Setter for Vendor Email
    public function getVendorEmail()
    {
        return $this->vendor_email;
    }

    public function setVendorEmail($vendor_email)
    {
        $this->vendor_email = $vendor_email;
    }

}