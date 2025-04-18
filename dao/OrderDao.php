<?php

use entities\Order;

class OrderDao
{
    public function createOrder(Order $order)
    {

    }

    public function updateOrder(Order $order)
    {

    }

    public function deleteOrder(Order $order)
    {

    }

    public function findOrder(Order $order)
    {

    }

    /**
     * @param Order $order
     * @param $customer_id
     * @return false|PDOStatement for all orders
     */
    public function findAllOrders($customer_id): false|PDOStatement
    {
        $sql = "SELECT order_id, order_date, order_time, amount, deliver_date, deliver_percent, deliver_status 
        FROM customer_order 
        WHERE customer_id = ? 
        ORDER BY order_id DESC";
        $stmt = getConnection()->prepare($sql);
        $stmt->bindParam(1, $customer_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function findOrderDetailsByCusIdAndOrderID($customer_id, $order_id): PDOStatement
    {
        $sql = "SELECT 
    co.order_id,
    co.customer_id,
    co.order_date,
    co.order_time,
    co.amount,
    co.deliver_date,
    co.deliver_percent,
    co.deliver_status,
    v.vendor_name,
    p.product_id,
    p.product_name,
    p.product_desc,
    p.product_category,
    p.product_qty,
    p.product_packaging,
    p.product_price,
    p.product_vendor,
    p.product_profile,
    p.product_visit_count,
    op.order_product_id,
    op.qty AS ordered_quantity,
    (op.qty * p.product_price) AS item_total_price
FROM 
    customer_order co
JOIN 
    order_product op ON co.order_id = op.order_id
JOIN 
    product p ON op.product_id = p.product_id
JOIN
    vendor v ON p.product_vendor = v.vendor_id
WHERE 
    co.customer_id = ?
    AND co.order_id = ?
ORDER BY 
    co.order_id DESC";
        $stmt = getConnection()->prepare($sql);
        $stmt->bindParam(1, $customer_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $order_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

}