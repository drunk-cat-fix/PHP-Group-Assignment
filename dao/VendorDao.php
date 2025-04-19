<?php

use entities\Vendor;

class VendorDao {

    /**
     * @return array
     */
    public function getAllVendors() {
        $sql = "SELECT * FROM vendors";
        $stmt = getConnection()->prepare($sql);
        $stmt->execute();
        $vendors = $stmt->fetchAll();
        return $vendors;
    }

    /**
     * @param $id
     * @return bool
     */
    public function getVendorById($id) {
        $sql = "SELECT * FROM vendors WHERE id = :id";
        $stmt = getConnection()->prepare($sql);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    /**
     * @param $email
     * @return bool
     */
    public function getVendorByEmail($email) {
        $sql = "SELECT * FROM vendors WHERE email = :email";
        $stmt = getConnection()->prepare($sql);
        $stmt->bindParam(":email", $email);
        return $stmt->execute();
    }

    /**
     * @param $vendor
     * @return bool
     */
    public function addVendor($vendor) :bool {
        $sql = "INSERT INTO vendor (vendor_name, vendor_pw, vendor_email, vendor_profile) VALUES (:name, :pw, :email, :profile)";

        $stmt = getConnection()->prepare($sql);
        $stmt->bindParam(":name", $vendor->getVendorName());
        $stmt->bindParam(":email", $vendor->getVendorEmail());
        $hashedPw = password_hash($vendor->getVendorPw(), PASSWORD_DEFAULT);
        $stmt->bindParam(":pw", $hashedPw);
        $stmt->bindParam(":profile", $vendor->getVendorProfile());
        return $stmt->execute();
    }

    /**
     * @param $vendor
     * @return bool
     */
    public function updateVendor($vendor) {
        $sql = "update vendors set vendor_name = :name, vendor_email = :email, vendor_profile = :profile where vendor_id = :id";
        $stmt = getConnection()->prepare($sql);
        $stmt->bindParam(":name", $vendor->getVendorName());
        $stmt->bindParam(":email", $vendor->getVendorEmail());
        $stmt->bindParam(":profile", $vendor->getVendorProfile());
        $stmt->bindParam(":id", $vendor->getId());
        return $stmt->execute();
    }

    public function deleteVendor($id) {
        $sql = "DELETE FROM vendors WHERE id = :id";
        $stmt = getConnection()->prepare($sql);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function updateProfileForVendor($vendor) {
        $sql = "UPDATE vendors set vendor_profile = :profile where vendor_id = :id";
        $stmt = getConnection()->prepare($sql);
        $stmt->bindParam(":profile", $vendor->getVendorProfile());
        $stmt->bindParam(":id", $vendor->getId());
        return $stmt->execute();
    }

    public function isExisted($uName,$uPwd): bool
    {
        $sql = "SELECT vendor_id,vendor_name, vendor_pw FROM vendor WHERE vendor_name = :uName";
        $stmt = getConnection()->prepare($sql);
        $stmt->bindParam(":uName", $uName);
        $stmt->execute();
        $vendor = $stmt->fetch();
//        var_dump($vendor&&password_verify($uPwd, $vendor->getVendorPw()));
        if ($vendor&&password_verify($uPwd, $vendor['vendor_pw'])) {
            $_SESSION['vendor_id'] = $vendor['vendor_id'];
            return true;
        }
        return false;
    }

    public function loadProfileForVendor($vendorId)
    {
        $sql = "SELECT vendor_profile FROM vendors WHERE vendor_id = :id";
        $stmt = getConnection()->prepare($sql);
        $stmt->bindParam(":id", $vendorId);
        $stmt->execute();
        $profile = $stmt->fetch(PDO::FETCH_ASSOC);
        $profile->setVendorProfile($profile['vendor_profile']);
        return $profile;
    }

    public function addProduct($vendor)
    {
        $sql = "INSERT INTO product (product_name, product_desc, product_category, product_qty, product_packaging, product_price, product_vendor, 
                product_profile) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $productName = $vendor->getProductName();
        $productDesc = $vendor->getProductDesc();
        $productCategory = $vendor->getProductCategory();
        $quantity = $vendor->getQuantity();
        $productPackaging = $vendor->getProductPackaging();
        $price = $vendor->getPrice();
        $vendor_id = $vendor->getId();
        $productProfile = $vendor->getProductProfile();        
        $stmt = getConnection()->prepare($sql);
        return $stmt->execute([$productName, $productDesc, $productCategory, $quantity, $productPackaging, $price, $vendor_id, $productProfile]);
    }

    public function updateQuantity(Vendor $vendor) {
        try {
            $conn = getConnection();
        
            // Double-check that we have necessary values
            $productId = $vendor->getProductID();
            $quantity = $vendor->getQuantity();
        
            if (empty($productId) || $quantity === null) {
                error_log("Missing required data for updateQuantity: product_id=" . 
                          $productId . ", quantity=" . $quantity);
                return false;
            }
        
            $sql = "UPDATE product SET product_qty = :qty WHERE product_id = :id";
            $stmt = $conn->prepare($sql);
        
            error_log("Updating product ID: " . $productId . " with new quantity: " . $quantity);
        
            $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
            $stmt->bindParam(':qty', $quantity, PDO::PARAM_INT);
        
            $result = $stmt->execute();
        
            if (!$result) {
                error_log("SQL error: " . implode(" ", $stmt->errorInfo()));
            } else {
                error_log("Rows affected: " . $stmt->rowCount());
                if ($stmt->rowCount() == 0) {
                    error_log("No rows updated. Check if product ID exists: " . $productId);
                }
            }
        
            return $result;
        } catch (\PDOException $e) {
            error_log("Database error in updateQuantity: " . $e->getMessage());
            return false;
        }
    }

    public function updateOrderStatus(Vendor $vendor)
    {
        $conn = getConnection();
        $updateStatusSql = "UPDATE order_product SET status = 'Complete' WHERE order_id = :order_id";
        $updateStmt = $conn->prepare($updateStatusSql);
        $updateStmt->bindValue(':order_id', $vendor->getOrderID(), PDO::PARAM_INT);
        $updateResult = $updateStmt->execute();
    }

    public function selectProductsInOrder($vendor)
    {
        $conn = getConnection();
        $productsSql = "SELECT op.product_id, op.qty FROM order_product op 
                    JOIN product p ON op.product_id = p.product_id 
                    WHERE op.order_id = :order_id AND p.product_vendor = :vendor_id";
        $productsStmt = $conn->prepare($productsSql);
        $productsStmt->bindValue(':order_id', $vendor->getOrderID(), PDO::PARAM_INT);
        $productsStmt->bindValue(':vendor_id', $vendor->getId(), PDO::PARAM_INT);
        $productsStmt->execute();
        $products = $productsStmt->fetchAll(PDO::FETCH_ASSOC);
        $vendor->setProducts($products);
    }

    public function calculateQuantity(Vendor $vendor)
    {
        $conn = getConnection();
        $products = $vendor->getProducts();
        foreach($products as $product) {
            $product_id = $product['product_id'];
            $order_quantity = $product['qty']; // Changed from 'quantity' to 'qty'                
            
            // Get current quantity
            $currentQtySql = "SELECT product_qty FROM product WHERE product_id = :product_id";
            $currentQtyStmt = $conn->prepare($currentQtySql);
            $currentQtyStmt->bindValue(':product_id', $product_id, PDO::PARAM_INT);
            $currentQtyStmt->execute();
            $currentQtyRow = $currentQtyStmt->fetch(PDO::FETCH_ASSOC);
                    
            $currentQty = $currentQtyRow['product_qty'];
                        
            // Calculate new quantity
            $newQty = $currentQty - $order_quantity;

            $vendor->setProductID($product_id);
            $vendor->setQuantity($newQty);
            $updateResult = $this->updateQuantity($vendor);
        }
    }

    public function editProduct(Vendor $vendor) {
        $conn = getConnection();
        $sql = "UPDATE product SET product_name = :name, product_desc = :desc, product_category = :category, product_qty = :qty, product_packaging = :packaging, 
            product_price = :price, product_profile = :profile WHERE product_id = :product_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':name', $vendor->getProductName());
        $stmt->bindValue(':desc', $vendor->getProductDesc());
        $stmt->bindValue(':category', $vendor->getProductCategory());
        $stmt->bindValue(':qty', $vendor->getQuantity());
        $stmt->bindValue(':packaging', $vendor->getProductPackaging());
        $stmt->bindValue(':price', $vendor->getPrice());
        $stmt->bindValue(':profile', $vendor->getProductProfile(), PDO::PARAM_LOB);
        $stmt->bindValue(':product_id', $vendor->getProductID());

        return $stmt->execute();
    }

    public function denyOrder(Vendor $vendor, $reason) {
        $conn = getConnection();

        try {
            // Start transaction
            $conn->beginTransaction();

            // 1. Update order_product table
            $sql1 = "UPDATE order_product 
                     SET status = 'Denied', reason = :reason, isRead = FALSE 
                     WHERE order_id = :order_id";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->bindValue(':order_id', $vendor->getOrderID(), PDO::PARAM_INT);
            $stmt1->bindValue(':reason', $reason, PDO::PARAM_STR);
            $stmt1->execute();

            // 2. Update customer_order table
            $sql2 = "UPDATE customer_order 
                     SET deliver_status = 'Denied' 
                     WHERE order_id = :order_id";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bindValue(':order_id', $vendor->getOrderID(), PDO::PARAM_INT);
            $stmt2->execute();

            // Commit transaction
            $conn->commit();
            return true;
        } catch (PDOException $e) {
            // Rollback transaction on error
            $conn->rollBack();
            error_log("Deny Order Error: " . $e->getMessage());
            return false;
        }
    }

    public function addService($vendor)
    {
        $sql = "INSERT INTO service (service_name, service_desc, service_category, service_price, service_vendor, service_profile) VALUES (?, ?, ?, ?, ?, ?)";
        $serviceName = $vendor->getServiceName();
        $serviceDesc = $vendor->getServiceDesc();
        $serviceCategory = $vendor->getServiceCategory();
        $price = $vendor->getPrice();
        $vendor_id = $vendor->getId();
        $serviceProfile = $vendor->getServiceProfile();        
        $stmt = getConnection()->prepare($sql);
        return $stmt->execute([$serviceName, $serviceDesc, $serviceCategory, $price, $vendor_id, $serviceProfile]);
    }

    public function editService(Vendor $vendor) {
        $conn = getConnection();
        $sql = "UPDATE service SET service_name = :name, service_desc = :desc, service_category = :category,
            service_price = :price, service_profile = :profile WHERE service_id = :service_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':name', $vendor->getServiceName());
        $stmt->bindValue(':desc', $vendor->getServiceDesc());
        $stmt->bindValue(':category', $vendor->getServiceCategory());
        $stmt->bindValue(':price', $vendor->getPrice());
        $stmt->bindValue(':profile', $vendor->getServiceProfile(), PDO::PARAM_LOB);
        $stmt->bindValue(':service_id', $vendor->getServiceID());

        return $stmt->execute();
    }

}