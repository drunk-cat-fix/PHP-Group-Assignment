<?php

use entities\Customer;
use entities\Staff;
use entities\Vendor;

if ($_POST) {
    $role = $_POST['role'];
    if ($role == 'Vendor') {
        $vendor = new Vendor();
        $vendor->setVendorName($_POST['username']);
        $vendor->setVendorEmail($_POST['email']);
        $vendor->setVendorPw($_POST['password']);
    }

    if ($role == 'Customer') {
        $customer = new Customer();
        $customer->setCustomerName($_POST['username']);
        $customer->setCustomerEmail($_POST['email']);
        $customer->setCustomerPw($_POST['password']);
    }

    if ($role == 'Staff') {
        $staff = new Staff();
        $staff->setStaffName($_POST['username']);
        $staff->setStaffEmail($_POST['email']);
        $staff->setStaffPw($_POST['password']);
    }
}