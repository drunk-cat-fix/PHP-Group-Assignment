<?php
require_once 'db.php';
require_once 'notifications.php';
checkAuth('vendor');

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_product'])) {
        $productId = count($_SESSION['products']) + 1;
        $_SESSION['products'][] = [
            'id' => $productId,
            'vendor_id' => $_SESSION['user']['id'],
            'name' => $_POST['name'],
            'price' => $_POST['price'],
            'quantity' => $_POST['quantity'],
            'unit' => $_POST['unit'],
            'category' => $_POST['category'],
            'image' => $_POST['image'],
            'description' => $_POST['description']
        ];
        $_SESSION['message'] = "Product added successfully!";
        header("Location: vendor_dashboard.php");
        exit();
    }
    elseif (isset($_POST['update_product'])) {
        foreach ($_SESSION['products'] as &$product) {
            if ($product['id'] == $_POST['product_id']) {
                $product['name'] = $_POST['name'];
                $product['price'] = $_POST['price'];
                $product['quantity'] = $_POST['quantity'];
                $product['unit'] = $_POST['unit'];
                $product['category'] = $_POST['category'];
                $product['image'] = $_POST['image'];
                $product['description'] = $_POST['description'];
                break;
            }
        }
        $_SESSION['message'] = "Product updated successfully!";
        header("Location: vendor_dashboard.php");
        exit();
    }
    elseif (isset($_POST['delete_product'])) {
        $_SESSION['products'] = array_filter($_SESSION['products'], function($product) {
            return $product['id'] != $_POST['product_id'];
        });
        $_SESSION['message'] = "Product deleted successfully!";
        header("Location: vendor_dashboard.php");
        exit();
    }
    elseif (isset($_POST['add_promotion'])) {
        $promoId = count($_SESSION['promotions']) + 1;
        $_SESSION['promotions'][] = [
            'id' => $promoId,
            'vendor_id' => $_SESSION['user']['id'],
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'discount' => $_POST['discount'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ];
        $_SESSION['message'] = "Promotion submitted for approval!";
        header("Location: vendor_dashboard.php");
        exit();
    }
}

// Get vendor's products
$vendorProducts = array_filter($_SESSION['products'] ?? [], function($product) {
    return $product['vendor_id'] == $_SESSION['user']['id'];
});

// Get vendor's promotions
$promotions = array_filter($_SESSION['promotions'] ?? [], function($promo) {
    return $promo['vendor_id'] == $_SESSION['user']['id'];
});

// Get notifications
$notifications = Notification::getUserNotifications($_SESSION['user']['id']);
$unreadCount = Notification::getUnreadCount($_SESSION['user']['id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vendor Management Hub</title>
    <style>
        /* Combined styles from both files */
        body { font-family: 'Segoe UI', sans-serif; margin: 0; padding: 20px; background-color: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding-bottom: 15px; border-bottom: 1px solid #eee; }
        .btn { padding: 8px 16px; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .btn-success { background-color: #4CAF50; }
        .btn-danger { background-color: #f44336; }
        .btn-info { background-color: #2196F3; }
        .product-grid, .promo-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; margin: 20px 0; }
        .card { border: 1px solid #ddd; padding: 15px; border-radius: 8px; }
        .pending { background-color: #fff8e1; }
        .approved { background-color: #e8f5e9; }
        .rejected { background-color: #ffebee; }
        .system { background-color: #e3f2fd; }
        .form-group { margin-bottom: 15px; }
        .hidden { display: none; }
        .notification-bell { position: relative; display: inline-block; margin-left: 20px; }
        #notificationDropdown { display: none; position: absolute; right: 0; background: white; box-shadow: 0 4px 8px rgba(0,0,0,0.1); min-width: 300px; z-index: 1000; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Vendor Management Hub</h1>
            <div class="auth-links">
                <!-- Notification system remains same -->
                <a href="index.php" class="btn btn-info">Store Front</a>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>

        <?php if(isset($_SESSION['message'])): ?>
            <div class="message"><?= $_SESSION['message'] ?></div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <!-- Product Management Section -->
        <section>
            <h2>Your Products</h2>
            <!-- Product form and grid from original vendor file -->
        </section>

        <!-- Promotion Management Section -->
        <section>
            <h2>Promotions Control Center</h2>
            
            <!-- System Promotion Form -->
            <div class="card">
                <h3>Create System-wide Promotion</h3>
                <form method="POST">
                    <!-- Form fields same as admin version -->
                    <button type="submit" name="add_system_promo" class="btn btn-success">Create System Promotion</button>
                </form>
            </div>

            <!-- Vendor Promotion Form -->
            <div class="card">
                <h3>Propose New Promotion</h3>
                <form method="POST">
                    <!-- Form fields from vendor version -->
                    <button type="submit" name="add_promotion" class="btn btn-info">Submit Promotion</button>
                </form>
            </div>

            <!-- Promotions List -->
            <div class="promo-grid">
                <?php foreach ($promotions as $promo): ?>
                    <div class="card <?= $promo['status'] ?>">
                        <h3><?= htmlspecialchars($promo['title']) ?></h3>
                        <p><?= htmlspecialchars($promo['description']) ?></p>
                        <p>Status: <?= ucfirst($promo['status']) ?></p>
                        
                        <?php if($promo['status'] === 'pending'): ?>
                            <form method="POST">
                                <input type="hidden" name="promo_id" value="<?= $promo['id'] ?>">
                                <button type="submit" name="approve_promo" class="btn btn-success">Approve</button>
                                <button type="submit" name="reject_promo" class="btn btn-danger">Reject</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</body>
</html>