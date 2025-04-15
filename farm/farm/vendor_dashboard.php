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
        header("Location: vendor_promotions.php");
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
        header("Location: vendor_promotions.php");
        exit();
    }
    // Add other form handlers similarly...
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        .auth-links a {
            margin-left: 15px;
        }
        .btn {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .btn-danger {
            background-color: #f44336;
        }
        .btn-danger:hover {
            background-color: #d32f2f;
        }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .product-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            background: white;
        }
        .product-image {
            max-width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        .form-group input, 
        .form-group select, 
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-group textarea {
            min-height: 100px;
        }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .success {
            background-color: #dff0d8;
            color: #3c763d;
        }
        .toggle-form-btn {
            margin-bottom: 20px;
        }
        .hidden {
            display: none;
        }
        .notification-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .notification-item.unread {
            background-color: #f8f8f8;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Vendor Dashboard</h1>
            <div class="auth-links">
                <span>Welcome, <?= htmlspecialchars($_SESSION['user']['username']) ?></span>
                <div class="notification-bell" style="position: relative; display: inline-block; margin-left: 20px;">
                    <button id="notificationBtn" style="background: none; border: none; cursor: pointer; font-size: 1.5em;">
                        🔔 <span id="unreadCount" style="background: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 0.7em; display: <?= $unreadCount > 0 ? 'inline-block' : 'none' ?>"><?= $unreadCount ?></span>
                    </button>
                    <div id="notificationDropdown" style="display: none; position: absolute; right: 0; background: white; box-shadow: 0 4px 8px rgba(0,0,0,0.1); min-width: 300px; z-index: 1000; max-height: 400px; overflow-y: auto;">
                        <?php foreach ($notifications as $notification): ?>
                            <div class="notification-item <?= $notification['is_read'] ? '' : 'unread' ?>">
                                <strong><?= htmlspecialchars($notification['title']) ?></strong>
                                <p><?= htmlspecialchars($notification['message']) ?></p>
                                <small><?= date('M j, Y g:i a', strtotime($notification['created_at'])) ?></small>
                            </div>
                        <?php endforeach; ?>
                        <?php if (empty($notifications)): ?>
                            <div style="padding: 10px;">No notifications</div>
                        <?php endif; ?>
                    </div>
                </div>
                <a href="index.php" class="btn">Back to Store</a>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="message success">
                <?= $_SESSION['message'] ?>
                <?php unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        <h2>Promotions</h2>
        <button id="togglePromoFormBtn" class="btn toggle-form-btn">Propose New Promotion</button>

        <div id="addPromoForm" class="hidden">
            <form method="POST">
                <div class="form-group">
                    <label for="title">Promotion Title:</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="discount">Discount (%):</label>
                    <input type="number" id="discount" name="discount" min="1" max="50" required>
                </div>
                <div class="form-group">
                    <label for="start_date">Start Date:</label>
                    <input type="datetime-local" id="start_date" name="start_date" required>
                </div>
                <div class="form-group">
                    <label for="end_date">End Date:</label>
                    <input type="datetime-local" id="end_date" name="end_date" required>
                </div>
                <button type="submit" name="add_promotion" class="btn">Submit Promotion</button>
            </form>
        </div>

        <div class="promotion-grid" style="margin-top: 20px;">
            <?php foreach ($promotions as $promo): ?>
                <div class="product-card">
                    <h3><?= htmlspecialchars($promo['title']) ?> (<?= $promo['discount'] ?>% off)</h3>
                    <p><?= htmlspecialchars($promo['description']) ?></p>
                    <p><strong>Status:</strong> <?= ucfirst($promo['status']) ?></p>
                    <p><strong>Period:</strong> <?= date('M j, Y', strtotime($promo['start_date'])) ?> to <?= date('M j, Y', strtotime($promo['end_date'])) ?></p>
                </div>
            <?php endforeach; ?>
            <?php if (empty($promotions)): ?>
                <p>You haven't created any promotions yet.</p>
            <?php endif; ?>
        </div>

        <h2>Your Products</h2>
        <button id="toggleFormBtn" class="btn toggle-form-btn">Add New Product</button>

        <div id="addProductForm" class="hidden">
            <h2>Add New Product</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="name">Product Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="price">Price (RM):</label>
                    <input type="number" id="price" name="price" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" step="0.1" required>
                </div>
                <div class="form-group">
                    <label for="unit">Unit:</label>
                    <select id="unit" name="unit" required>
                        <option value="per kg">per kg</option>
                        <option value="per piece">per piece</option>
                        <option value="per tray">per tray</option>
                        <option value="per liter">per liter</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="category">Category:</label>
                    <select id="category" name="category" required>
                        <option value="dairy">Dairy</option>
                        <option value="poultry">Poultry</option>
                        <option value="vegetables">Vegetables</option>
                        <option value="fruits">Fruits</option>
                        <option value="seafood">Seafood</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="image">Image URL:</label>
                    <input type="text" id="image" name="image" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                <button type="submit" name="add_product" class="btn">Add Product</button>
            </form>
        </div>

        <?php if (empty($vendorProducts)): ?>
            <p>You haven't added any products yet.</p>
        <?php else: ?>
            <div class="product-grid">
                <?php foreach ($vendorProducts as $product): ?>
                <div class="product-card">
                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image">
                    <form method="POST">
                        <div class="form-group">
                            <label>Name:</label>
                            <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Price (RM):</label>
                            <input type="number" name="price" step="0.01" value="<?= $product['price'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Quantity:</label>
                            <input type="number" name="quantity" step="0.1" value="<?= $product['quantity'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Unit:</label>
                            <select name="unit" required>
                                <option value="per kg" <?= $product['unit'] == 'per kg' ? 'selected' : '' ?>>per kg</option>
                                <option value="per piece" <?= $product['unit'] == 'per piece' ? 'selected' : '' ?>>per piece</option>
                                <option value="per tray" <?= $product['unit'] == 'per tray' ? 'selected' : '' ?>>per tray</option>
                                <option value="per liter" <?= $product['unit'] == 'per liter' ? 'selected' : '' ?>>per liter</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Category:</label>
                            <select name="category" required>
                                <option value="dairy" <?= $product['category'] == 'dairy' ? 'selected' : '' ?>>Dairy</option>
                                <option value="poultry" <?= $product['category'] == 'poultry' ? 'selected' : '' ?>>Poultry</option>
                                <option value="vegetables" <?= $product['category'] == 'vegetables' ? 'selected' : '' ?>>Vegetables</option>
                                <option value="fruits" <?= $product['category'] == 'fruits' ? 'selected' : '' ?>>Fruits</option>
                                <option value="seafood" <?= $product['category'] == 'seafood' ? 'selected' : '' ?>>Seafood</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Image URL:</label>
                            <input type="text" name="image" value="<?= htmlspecialchars($product['image']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Description:</label>
                            <textarea name="description" required><?= htmlspecialchars($product['description']) ?></textarea>
                        </div>
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <button type="submit" name="update_product" class="btn">Update Product</button>
                    </form>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Toggle the add product form
        document.getElementById('toggleFormBtn').addEventListener('click', function() {
            const form = document.getElementById('addProductForm');
            form.classList.toggle('hidden');
            this.textContent = form.classList.contains('hidden') ? 'Add New Product' : 'Cancel';
        });

        // Toggle promotion form
        document.getElementById('togglePromoFormBtn').addEventListener('click', function() {
            const form = document.getElementById('addPromoForm');
            form.classList.toggle('hidden');
            this.textContent = form.classList.contains('hidden') ? 'Propose New Promotion' : 'Cancel';
        });

        // Notification dropdown toggle
        document.getElementById('notificationBtn').addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = document.getElementById('notificationDropdown');
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
            
            // Mark notifications as read when dropdown is opened
            if (dropdown.style.display === 'block') {
                fetch('mark_notifications_read.php')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('unreadCount').style.display = 'none';
                            document.querySelectorAll('.notification-item.unread').forEach(el => {
                                el.classList.remove('unread');
                            });
                        }
                    });
            }
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function() {
            document.getElementById('notificationDropdown').style.display = 'none';
        });
    </script>
</body>
</html>