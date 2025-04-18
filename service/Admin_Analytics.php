<?php
require_once 'Utilities/Connection.php';
$conn = getConnection();

// Most viewed products
$viewed = $conn->query("SELECT product_name, product_visit_count FROM product ORDER BY product_visit_count DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);

// Most searched products
$searched = $conn->query("SELECT product_name, product_search_count FROM product ORDER BY product_search_count DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);

// Most visited shops
$shopViewed = $conn->query("SELECT shop_name, vendor_visit_count FROM vendor ORDER BY vendor_visit_count DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);

// Most searched shops
$shopSearched = $conn->query("SELECT shop_name, shop_search_count FROM vendor ORDER BY shop_search_count DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);

// Most ordered products
$ordered = $conn->query("
    SELECT p.product_name, SUM(op.qty) as total_qty
    FROM order_product op
    JOIN product p ON op.product_id = p.product_id
    GROUP BY op.product_id
    ORDER BY total_qty DESC
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

// Weekly sales
$weekly = $conn->query("
    SELECT DATE(order_date) as date, SUM(amount) as total
    FROM customer_order
    WHERE order_date >= CURDATE() - INTERVAL 7 DAY
    GROUP BY DATE(order_date)
    ORDER BY date ASC
")->fetchAll(PDO::FETCH_ASSOC);

// Monthly sales
$monthly = $conn->query("
    SELECT MONTHNAME(order_date) as month, SUM(amount) as total
    FROM customer_order
    WHERE order_date >= CURDATE() - INTERVAL 12 MONTH
    GROUP BY MONTH(order_date)
    ORDER BY MONTH(order_date)
")->fetchAll(PDO::FETCH_ASSOC);

// Quarterly sales
$quarterly = $conn->query("
    SELECT CONCAT('Q', QUARTER(order_date)) as quarter, SUM(amount) as total
    FROM customer_order
    WHERE order_date >= CURDATE() - INTERVAL 1 YEAR
    GROUP BY QUARTER(order_date)
    ORDER BY QUARTER(order_date)
")->fetchAll(PDO::FETCH_ASSOC);

// Annual sales
$annually = $conn->query("
    SELECT YEAR(order_date) as year, SUM(amount) as total
    FROM customer_order
    GROUP BY YEAR(order_date)
    ORDER BY year
")->fetchAll(PDO::FETCH_ASSOC);

function jsonData($data, $key) {
    return json_encode(array_column($data, $key));
}
?>