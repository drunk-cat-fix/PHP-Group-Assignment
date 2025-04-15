<?php
session_start();

// Hardcoded promotions (replace database query)
$activePromotions = [
    [
        'id' => 1,
        'code' => 'SUMMER10',
        'discount' => 10,
        'type' => 'percentage',
        'status' => 'system',
        'start_date' => '2023-01-01',
        'end_date' => '2024-12-31'
    ]
];
$appliedPromotion = $activePromotions[0] ?? null;

foreach ($activePromotions as $promo) {
    // Simple logic - apply first found promotion
    // You might want more complex logic based on product categories, etc.
    $appliedPromotion = $promo;
    break;
}

// Process cart operations
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle Add to Cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product'], $_POST['price'], $_POST['unit'], $_POST['quantity'])) {
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product'] === $_POST['product']) {
            $item['quantity'] += floatval($_POST['quantity']);
            $found = true;
            break;
        }
    }
    if (!$found) {
        $_SESSION['cart'][] = [
            'product' => $_POST['product'],
            'price' => floatval($_POST['price']),
            'unit' => $_POST['unit'],
            'quantity' => floatval($_POST['quantity'])
        ];
    }
    
    header("Location: cart.php");
    exit;
}

// Update quantity
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product'] === $_POST['product']) {
            $item['quantity'] = floatval($_POST['quantity']);
            $_SESSION['toast'] = 'Updated successfully';
            break;
        }
    }
    header("Location: cart.php");
    exit;
}

// Remove item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) {
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['product'] === $_POST['product']) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
            $_SESSION['toast'] = 'Removed successfully';
            break;
        }
    }
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Maintain the exact cart.php styles you provided */
        body { font-family: 'Segoe UI', sans-serif; background-color: #f9f9f9; margin: 0; padding: 20px; }
        .container { max-width: 900px; margin: auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #2e7d32; }
        .cart-table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        .cart-table th, .cart-table td { padding: 14px; text-align: center; border-bottom: 1px solid #ccc; }
        .cart-table th { background-color: #e8f5e9; color: #2e7d32; }
        .cart-table input[type="number"] { width: 70px; padding: 6px; }
        .btn { padding: 8px 14px; border: none; border-radius: 6px; cursor: pointer; font-size: 0.9rem; }
        .update-btn { background-color: #2196f3; color: #fff; }
        .remove-btn { background-color: #e53935; color: #fff; }
        .continue-btn, .pay-btn { background-color: #4caf50; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 6px; display: inline-block; transition: background-color 0.3s ease; }
        .continue-btn:hover, .pay-btn:hover { background-color: #388e3c; }
        .empty-message { text-align: center; color: #888; margin-top: 40px; font-size: 1.2rem; }
        #toast { position: fixed; bottom: 20px; right: 20px; background: rgba(0,0,0,0.8); color: #fff; padding: 14px 20px; border-radius: 12px; opacity: 0; transition: opacity 0.3s ease; z-index: 999; }
        .buttons-container { text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Shopping Cart</h1>

        <?php if (!empty($_SESSION['cart'])): ?>
            <table class="cart-table">
                <tr>
                    <th>Product</th>
                    <th>Unit</th>
                    <th>Price (RM)</th>
                    <th>Quantity</th>
                    <th>Total (RM)</th>
                    <th>Actions</th>
                </tr>
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $item):
                    $item_total = $item['price'] * $item['quantity'];
                    $total += $item_total;
                ?>
                <tr>
                    <td><?= htmlspecialchars($item['product']) ?></td>
                    <td><?= htmlspecialchars($item['unit']) ?></td>
                    <td><?= number_format($item['price'], 2) ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="product" value="<?= htmlspecialchars($item['product']) ?>">
                            <input type="number" name="quantity" value="<?= $item['quantity'] ?>" step="<?= $item['unit'] === 'piece' ? '1' : '0.1' ?>" min="0.1">
                            <button type="submit" name="update" class="btn update-btn">Update</button>
                        </form>
                    </td>
                    <td><?= number_format($item_total, 2) ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="product" value="<?= htmlspecialchars($item['product']) ?>">
                            <button type="submit" name="remove" class="btn remove-btn">Remove</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4" style="text-align:right; font-weight:bold;">Total Price:</td>
                    <td colspan="2" style="text-align:center; font-weight:bold; color: #2e7d32;">
                        RM <?= number_format($total, 2) ?>
                    </td>
                </tr>
            </table>

            <div class="buttons-container">
                <a href="index.php" class="btn continue-btn">← Continue Shopping</a>
                <a href="payment.php" class="btn pay-btn">Proceed to Payment</a>
            </div>
        <?php else: ?>
            <p class="empty-message">Your cart is currently empty.</p>
            <div class="buttons-container">
                <a href="index.php" class="btn continue-btn">← Continue Shopping</a>
            </div>
        <?php endif; ?>
    </div>

    <div id="toast"></div>
    <script>
        const toast = document.getElementById('toast');
        <?php if (!empty($_SESSION['toast'])): ?>
            toast.textContent = "<?= $_SESSION['toast'] ?>";
            toast.style.opacity = 1;
            setTimeout(() => toast.style.opacity = 0, 2500);
            <?php unset($_SESSION['toast']); ?>
        <?php endif; ?>
    </script>
</body>
</html>