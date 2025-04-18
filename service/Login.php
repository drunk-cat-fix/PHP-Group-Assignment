<?php
session_start();
use entities\Admin;
use entities\Customer;
use entities\Staff;
use entities\Vendor;

require_once '../entities/Admin.php';
require_once '../dao/AdminDao.php';
require_once '../dao/CustomerDao.php';
require_once '../entities/Customer.php';
require_once '../dao/StaffDao.php';
require_once '../entities/Staff.php';
require_once '../dao/VendorDao.php';
require_once '../entities/Vendor.php';

if ($_POST) {
    $role = $_POST['roles'];
    if ($role == 'vendor') {
        $vendor = new Vendor();
        $vendor->setVendorName($_POST['username']);
        $vendor->setVendorEmail($_POST['email']);
        $vendor->setVendorPw($_POST['password']);
        $vendorDao = new VendorDao();
        if ($vendorDao->isExisted($vendor->getVendorName(),$vendor->getVendorPw())) {

            header('Location: ../vendor_manage_order.php');
        }else{
            header('Location: ../login.php?errMsg=Invalid username or password!');
        }
    }

    if ($role == 'customer') {
        $customer = new Customer();
        $customer->setCustomerName($_POST['username']);
        $customer->setCustomerEmail($_POST['email']);
        $customer->setCustomerPw($_POST['password']);
        $customerDao = new CustomerDao();
        if ($customerDao->isExisted($customer->getCustomerName(),$customer->getCustomerPw())) {
            header("location: ../products.php");
        }else{
            header("location: ../login.php?errMsg=Invalid username or password!");
        }
    }

    if ($role == 'staff') {
        $staff = new Staff();
        $staff->setStaffName($_POST['username']);
        $staff->setStaffEmail($_POST['email']);
        $staff->setStaffPw($_POST['password']);

        $staffDao = new StaffDao();
        $staffData = $staffDao->isExisted($staff->getStaffName(), $staff->getStaffPw());

        if ($staffData) {
            $_SESSION['staff_id'] = $staffData['staff_id'];
            ?>
            <form id="redirectForm" action="../staff_dashboard.php" method="post">
                <input type="hidden" name="staff_id" value="<?php echo $staffData['staff_id']; ?>">
            </form>
            <script>
                document.getElementById('redirectForm').submit();
            </script>
            <?php
            exit();
        } else {
            header("location: ../login.php?errMsg=Invalid username or password!");
        }
    }

    if ($role == 'admin') {
        $admin = new Admin();
        $admin->setAdminName($_POST['username']);
        $admin->setAdminPw($_POST['password']);
        $adminDao = new AdminDao();
        $status = $adminDao->isExisted($admin);
//        print_r($status);
        if ($status) {
            header("location: ../admin_manage_order.php");
        } else {
            header("location: ../login.php?errMsg=Invalid username or password!");
        }

    }

    if ($role == '') {
        header("location: ../login.php");
    }

}