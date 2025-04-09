<?php

namespace entities;
class Order
{
    private mixed $orderId;
    private $customerId;
    private $orderDate;
    private $orderStatus;
    private $orderTime;
    private $amount;
    private $deliverDate;
    private $deliverPercent;

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param mixed $orderId
     */
    public function setOrderId($orderId): void
    {
        $this->orderId = $orderId;
    }

    /**
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param mixed $customerId
     */
    public function setCustomerId($customerId): void
    {
        $this->customerId = $customerId;
    }

    /**
     * @return mixed
     */
    public function getOrderDate()
    {
        return $this->orderDate;
    }

    /**
     * @param mixed $orderDate
     */
    public function setOrderDate($orderDate): void
    {
        $this->orderDate = $orderDate;
    }

    /**
     * @return mixed
     */
    public function getOrderStatus()
    {
        return $this->orderStatus;
    }

    /**
     * @param mixed $orderStatus
     */
    public function setOrderStatus($orderStatus): void
    {
        $this->orderStatus = $orderStatus;
    }

    /**
     * @return mixed
     */
    public function getOrderTime()
    {
        return $this->orderTime;
    }

    /**
     * @param mixed $orderTime
     */
    public function setOrderTime($orderTime): void
    {
        $this->orderTime = $orderTime;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getDeliverDate()
    {
        return $this->deliverDate;
    }

    /**
     * @param mixed $deliverDate
     */
    public function setDeliverDate($deliverDate): void
    {
        $this->deliverDate = $deliverDate;
    }

    /**
     * @return mixed
     */
    public function getDeliverPercent()
    {
        return $this->deliverPercent;
    }

    /**
     * @param mixed $deliverPercent
     */
    public function setDeliverPercent($deliverPercent): void
    {
        $this->deliverPercent = $deliverPercent;
    }

}