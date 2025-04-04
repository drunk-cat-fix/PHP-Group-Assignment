<?php
require_once __DIR__. "/../dao/OrderDao.php";
require_once __DIR__. "/../Utilities/Connection.php";
require_once __DIR__. "/../dao/PreferenceDao.php";

function getAllOrderHistory($customerId): false|PDOStatement
{
    $orderDao = new OrderDao();
    return $orderDao->findAllOrders($customerId);
}

function getOrderDetailsByCustomerIdAndOrderId($customerId, $orderId): PDOStatement
{
    $orderDao = new OrderDao();
    return $orderDao->findOrderDetailsByCusIdAndOrderID($customerId,$orderId);
}

function getAllPreferencesByCusId($customerId): false|PDOStatement
{
    $preferenceDao = new PreferenceDao();
    return $preferenceDao->getAllPreferencesByCustomerId($customerId);
}

?>