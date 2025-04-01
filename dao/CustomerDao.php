<?php

use entities\Customer;

//require_once "entities/Customer.php";
class CustomerDao {
    public function getAllCustomers() {
        $sql = "SELECT * FROM customers";
        $stmt = getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getCustomerById($id) {
        $sql = "SELECT customer_id, customer_pw, customer_name, customer_addre, customer_city, customer_state, customer_profile, customer_email ".
                " FROM customer WHERE customer_id = :id ";
        $stmt = getConnection()->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function getCustomerByEmail($email) {
        $sql = "SELECT customer_id, customer_pw, customer_name, customer_addre, customer_city, customer_state, customer_profile, customer_email ".
            " FROM customer WHERE customer_email = :email ";
        $stmt = getConnection()->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function addCustomer(Customer $customer) :int{
        $sql = " insert into customer (customer_name, customer_pw, customer_profile, customer_email) ".
                " values (:name, :pw, :profile, :email) ";
        $stmt = getConnection()->prepare($sql);
        $customerName = $customer->getCustomerName();
        $stmt->bindParam(":name", $customerName);
        $customerPw = $customer->getCustomerPw();
        $hashPw = password_hash($customerPw, PASSWORD_DEFAULT);
        $stmt->bindParam(":pw", $hashPw);
        $customerProfile = $customer->getCustomerProfile();
        $stmt->bindParam(":profile", $customerProfile);
        $customerEmail = $customer->getCustomerEmail();
        $stmt->bindParam(":email", $customerEmail);
        $row=$stmt->execute();
        return $row;
    }

    public function updateCustomer(Customer $customer):int {
        $sql = "UPDATE customer SET customer_name = :name,  customer_profile = :profile,  customer_email = :email ";
        $stmt = getConnection()->prepare($sql);
        $customerName = $customer->getCustomerName();
        $stmt->bindParam(":name", $customerName);
        $customerProfile = $customer->getCustomerProfile();
        $stmt->bindParam(":profile", $customerProfile);
        $customerEmail = $customer->getCustomerEmail();
        $stmt->bindParam(":email", $customerEmail);
        $result = $stmt->execute();
        return $result;
    }
    public function deleteCustomerById($id) {
        $sql = "DELETE FROM customer WHERE customer_id = :id ";
        $stmt = getConnection()->prepare($sql);
        $stmt->bindParam(":id", $id);
        $result = $stmt->execute();
        return $result;
    }

    public function updateProfileForCustomerById($profile,$customer_id) {
        $sql = "UPDATE customer SET customer_profile = :profile where customer_id = :id ";
        $stmt = getConnection()->prepare($sql);
        $customerProfile = $profile;
        $stmt->bindParam(":profile", $customerProfile);
        $stmt->bindParam(":id", $customer_id);
        $result = $stmt->execute();
        return $result;
    }

    public function isExisted($username,$pwd):bool{
        $sql = " select customer_name, customer_pw from customer where customer_name = :name ";
        $stmt = getConnection()->prepare($sql);
        $stmt->bindParam(":name", $username);
        $stmt->execute();
        $row = $stmt->fetch();
        if($row&&password_verify($pwd,$row["customer_pw"])){
            return true;
        }
        return false;



    }



}