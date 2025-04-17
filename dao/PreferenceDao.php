<?php

class PreferenceDao
{
    public function getAllPreferencesByCustomerId($customerId): PDOstatement
    {
        $sql = "SELECT
    c.customer_id,
    c.customer_name,
    c.customer_email,
    c.customer_city,
    c.customer_state,
    p.product_id,
    p.product_name,
    p.product_desc,
    p.product_category,
    p.product_price,
    p.product_profile,
    cp.preference_id
FROM
    customer c
JOIN
    customer_preference cp ON c.customer_id = cp.customer_id
JOIN
    product p ON cp.product_id = p.product_id
WHERE
    c.customer_id = ?
ORDER BY
    p.product_name";
        $stmt = getCOnnection()->prepare($sql);
        $stmt->bindParam(1, $customerId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

}