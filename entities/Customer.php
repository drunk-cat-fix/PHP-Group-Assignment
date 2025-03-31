<?php

namespace entities;

class Customer
{
    private $customer_id;
    private $customer_pw;
    private $customer_name;

    private $customer_address;
    private $customer_city;
    private $customer_state;
    private $customer_profile;
    private $customer_email;

    /**
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * @param mixed $customer_id
     */
    public function setCustomerId($customer_id)
    {
        $this->customer_id = $customer_id;
    }

    /**
     * @return mixed
     */
    public function getCustomerPw()
    {
        return $this->customer_pw;
    }

    /**
     * @param mixed $customer_pw
     */
    public function setCustomerPw($customer_pw)
    {
        $this->customer_pw = $customer_pw;
    }

    /**
     * @return mixed
     */
    public function getCustomerName()
    {
        return $this->customer_name;
    }

    /**
     * @param mixed $customer_name
     */
    public function setCustomerName($customer_name)
    {
        $this->customer_name = $customer_name;
    }

    /**
     * @return mixed
     */
    public function getCustomerAddress()
    {
        return $this->customer_address;
    }

    /**
     * @param mixed $customer_address
     */
    public function setCustomerAddress($customer_address)
    {
        $this->customer_address = $customer_address;
    }

    /**
     * @return mixed
     */
    public function getCustomerCity()
    {
        return $this->customer_city;
    }

    /**
     * @param mixed $customer_city
     */
    public function setCustomerCity($customer_city)
    {
        $this->customer_city = $customer_city;
    }

    /**
     * @return mixed
     */
    public function getCustomerState()
    {
        return $this->customer_state;
    }

    /**
     * @param mixed $customer_state
     */
    public function setCustomerState($customer_state)
    {
        $this->customer_state = $customer_state;
    }

    /**
     * @return mixed
     */
    public function getCustomerProfile()
    {
        return $this->customer_profile;
    }

    /**
     * @param mixed $customer_profile
     */
    public function setCustomerProfile($customer_profile)
    {
        $this->customer_profile = $customer_profile;
    }

    /**
     * @return mixed
     */
    public function getCustomerEmail()
    {
        return $this->customer_email;
    }

    /**
     * @param mixed $customer_email
     */
    public function setCustomerEmail($customer_email)
    {
        $this->customer_email = $customer_email;
    }

}