<?php
require_once "Utilities/Connection.php";
class ProductDao {
    function getAllProducts($orderBy): array
    {
        $sql = "SELECT 
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
    p.product_promotion, 
    p.promo_start_date AS product_promo_start_date,
    p.promo_end_date AS product_promo_end_date,
    v.vendor_id, 
    v.vendor_pw, 
    v.vendor_name, 
    v.shop_name, 
    v.shop_address, 
    v.shop_city, 
    v.shop_state, 
    v.vendor_desc, 
    v.vendor_tier, 
    v.vendor_visit_count, 
    v.vendor_profile, 
    v.vendor_email, 
    v.vendor_promotion, 
    v.promo_start_date AS vendor_promo_start_date, 
    v.promo_end_date AS vendor_promo_end_date
FROM 
    product p
JOIN 
    vendor v ON p.product_vendor = v.vendor_id
ORDER BY '$orderBy' DESC"
    ;

        $smt = getConnection()->prepare($sql);
        $smt->execute();
        return $smt->fetchAll(PDO::FETCH_ASSOC);
    }
}