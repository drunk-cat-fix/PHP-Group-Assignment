<?php

namespace entities;

class Vendor
{
    private $id;
    private $vendor_name;
    private $vendor_pw;
    private $shop_name;
    private $shop_address;
    private $shop_city;
    private $shop_state;
    private $vendor_desc;
    private $vendor_tier;
    private $vendor_visit_co;
    private $vendor_profile;
    private $vendor_email;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getVendorName()
    {
        return $this->vendor_name;
    }

    /**
     * @param mixed $vendor_name
     */
    public function setVendorName($vendor_name)
    {
        $this->vendor_name = $vendor_name;
    }

    /**
     * @return mixed
     */
    public function getVendorPw()
    {
        return $this->vendor_pw;
    }

    /**
     * @param mixed $vendor_pw
     */
    public function setVendorPw($vendor_pw)
    {
        $this->vendor_pw = $vendor_pw;
    }

    /**
     * @return mixed
     */
    public function getShopName()
    {
        return $this->shop_name;
    }

    /**
     * @param mixed $shop_name
     */
    public function setShopName($shop_name)
    {
        $this->shop_name = $shop_name;
    }

    /**
     * @return mixed
     */
    public function getShopAddress()
    {
        return $this->shop_address;
    }

    /**
     * @param mixed $shop_address
     */
    public function setShopAddress($shop_address)
    {
        $this->shop_address = $shop_address;
    }

    /**
     * @return mixed
     */
    public function getShopCity()
    {
        return $this->shop_city;
    }

    /**
     * @param mixed $shop_city
     */
    public function setShopCity($shop_city)
    {
        $this->shop_city = $shop_city;
    }

    /**
     * @return mixed
     */
    public function getShopState()
    {
        return $this->shop_state;
    }

    /**
     * @param mixed $shop_state
     */
    public function setShopState($shop_state)
    {
        $this->shop_state = $shop_state;
    }

    /**
     * @return mixed
     */
    public function getVendorDesc()
    {
        return $this->vendor_desc;
    }

    /**
     * @param mixed $vendor_desc
     */
    public function setVendorDesc($vendor_desc)
    {
        $this->vendor_desc = $vendor_desc;
    }

    /**
     * @return mixed
     */
    public function getVendorTier()
    {
        return $this->vendor_tier;
    }

    /**
     * @param mixed $vendor_tier
     */
    public function setVendorTier($vendor_tier)
    {
        $this->vendor_tier = $vendor_tier;
    }

    /**
     * @return mixed
     */
    public function getVendorVisitCo()
    {
        return $this->vendor_visit_co;
    }

    /**
     * @param mixed $vendor_visit_co
     */
    public function setVendorVisitCo($vendor_visit_co)
    {
        $this->vendor_visit_co = $vendor_visit_co;
    }

    /**
     * @return mixed
     */
    public function getVendorProfile()
    {
        return $this->vendor_profile;
    }

    /**
     * @param mixed $vendor_profile
     */
    public function setVendorProfile($vendor_profile)
    {
        $this->vendor_profile = $vendor_profile;
    }

    /**
     * @return mixed
     */
    public function getVendorEmail()
    {
        return $this->vendor_email;
    }

    /**
     * @param mixed $vendor_email
     */
    public function setVendorEmail($vendor_email)
    {
        $this->vendor_email = $vendor_email;
    }

}