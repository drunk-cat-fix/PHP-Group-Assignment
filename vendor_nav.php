<?php
require_once 'service/Vendor_Notification.php';
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
    <a href="vendor_account_settings.php">Account Settings</a>
    <a href="vendor_add_product.php">Add Product</a>
    <a href="vendor_add_service.php">Add Service</a>
    <a href="vendor_manage_order.php">Manage Orders</a>
    <a href="vendor_product.php">My Products</a>
    <a href="vendor_service.php">My Services</a>
    <a href="vendor_promotions.php">Promotions</a>
    <a href="vendor_shop_review.php">View Customer Reviews</a>
    <a href="vendor_notifications_page.php" class="notification">
        🔔<span class="badge"><?= $notificationCount ?></span>
    </a>
    <div class="vendor-navbar-right">
        <a href="logout.php" style="background-color: #dc3545;">Logout</a>
    </div>
</div>
