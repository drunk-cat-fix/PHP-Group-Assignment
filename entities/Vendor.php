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
    private $product_id;
    private $quantity;
    private $order_id;
    private $products;

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

     // Setter for productID
    public function setProductID($product_id)
    {
        $this->product_id = $product_id;
    }

    // Getter for productID
    public function getProductID()
    {
        return $this->product_id;
    }

    // Setter for productName
    public function setProductName($productName)
    {
        $this->productName = $productName;
    }

    // Getter for productName
    public function getProductName()
    {
        return $this->productName;
    }

    // Setter for productDesc
    public function setProductDesc($productDesc)
    {
        $this->productDesc = $productDesc;
    }

    // Getter for productDesc
    public function getProductDesc()
    {
        return $this->productDesc;
    }

    // Setter for productCategory
    public function setProductCategory($productCategory)
    {
        $this->productCategory = $productCategory;
    }

    // Getter for productCategory
    public function getProductCategory()
    {
        return $this->productCategory;
    }

    // Setter for quantity
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    // Getter for quantity
    public function getQuantity()
    {
        return $this->quantity;
    }

    // Setter for productPackaging
    public function setProductPackaging($productPackaging)
    {
        $this->productPackaging = $productPackaging;
    }

    // Getter for productPackaging
    public function getProductPackaging()
    {
        return $this->productPackaging;
    }

    // Setter for price
    public function setPrice($price)
    {
        $this->price = $price;
    }

    // Getter for price
    public function getPrice()
    {
        return $this->price;
    }

    public function setProductProfile($productProfile)
    {
        $this->productProfile = $productProfile;
    }

    public function getProductProfile()
    {
        return $this->productProfile;
    }

    public function setOrderID($order_id)
    {
        $this->order_id = $order_id;
    }

    public function getOrderID()
    {
        return $this->order_id;
    }

    public function setProducts($products)
    {
        $this->products = $products;
    }

    public function getProducts()
    {
        return $this->products;
    }

     // Setter for serviceID
    public function setServiceID($service_id)
    {
        $this->service_id = $service_id;
    }

    // Getter for serviceID
    public function getServiceID()
    {
        return $this->service_id;
    }

    // Setter for serviceName
    public function setServiceName($serviceName)
    {
        $this->serviceName = $serviceName;
    }

    // Getter for serviceName
    public function getServiceName()
    {
        return $this->serviceName;
    }

    // Setter for serviceDesc
    public function setServiceDesc($serviceDesc)
    {
        $this->serviceDesc = $serviceDesc;
    }

    // Getter for serviceDesc
    public function getServiceDesc()
    {
        return $this->serviceDesc;
    }

    // Setter for serviceCategory
    public function setServiceCategory($serviceCategory)
    {
        $this->serviceCategory = $serviceCategory;
    }

    // Getter for serviceCategory
    public function getServiceCategory()
    {
        return $this->serviceCategory;
    }

    public function setServiceProfile($serviceProfile)
    {
        $this->serviceProfile = $serviceProfile;
    }

    public function getServiceProfile()
    {
        return $this->serviceProfile;
    }

}