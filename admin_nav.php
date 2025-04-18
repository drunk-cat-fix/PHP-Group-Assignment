<?php
require_once 'service/Admin_Notification.php';
$notificationCount = count($notifications);
?>
<style>
    .vendor-navbar {
        width: 100%;
        background-color: #343a40;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 24px;
        box-sizing: border-box;
        font-family: 'Segoe UI', sans-serif;
        flex-wrap: wrap;
    }

    .vendor-navbar-left,
    .vendor-navbar-right {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .vendor-navbar a {
        color: #ffffff;
        text-decoration: none;
        padding: 8px 14px;
        border-radius: 4px;
        transition: background-color 0.2s ease;
        font-size: 14px;
    }

    .vendor-navbar a:hover {
        background-color: #495057;
    }

    .notification-icon {
        font-size: 18px;
        background-color: #495057;
        border-radius: 50%;
        padding: 6px 10px;
    }

    .notification-icon:hover {
        background-color: #6c757d;
    }

    /* Add styles for notification icon in two rows */
    .notification {
        display: flex;
        flex-direction: column; /* Stack the notification icon and badge vertically */
        justify-content: center;
        align-items: center;
        position: relative;
        gap: 4px;  /* Space between icon and count */
    }

    .notification .badge {
        position: absolute;
        top: 0;
        right: 0;
        background-color: red;
        color: white;
        border-radius: 50%;
        font-size: 10px;
        padding: 4px 6px;
    }

    @media (max-width: 768px) {
        .vendor-navbar {
            flex-direction: column;
            align-items: flex-start;
        }

        .vendor-navbar-left,
        .vendor-navbar-right {
            flex-direction: column;
            width: 100%;
            gap: 8px;
            margin-top: 8px;
        }

        .vendor-navbar-right {
            align-items: flex-start;
        }
    }

</style>

<div class="vendor-navbar">
    <a href="admin_add_task.php">Add Task</a>
    <a href="admin_analytics.php">Analytics Reports</a>
    <a href="admin_customer_list.php">Customer List</a>
    <a href="admin_manage_order.php">Manage Orders</a>
    <a href="admin_manage_staff.php">Manage Staff</a>
    <a href="admin_order_history.php">Customer Order History List</a>
    <a href="admin_task_list.php">Task List</a>
    <a href="system_add_vendor.php">Add New Vendor</a>
    <a href="system_product.php">Product List</a>
    <a href="system_service.php">Service List</a>
    <a href="system_vendor_list.php">Vendor List</a>
    <a href="system_add_vendor.php">Add New Vendor</a>
    <a href="system_view_complaint.php">Complaint List</a>
    <a href="admin_notifications_page.php">
        🔔<span class="badge"><?= $notificationCount ?></span>
    </a>
    <div class="vendor-navbar-right">
        <a href="logout.php" style="background-color: #dc3545;">Logout</a>
    </div>

</div>
