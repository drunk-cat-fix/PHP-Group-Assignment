<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Cart page styling */
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

        <?php if (!empty($productDetails)): ?>
            <table class="cart-table">
                <tr>
                    <th>Product</th>
                    <th>Price (RM)</th>
                    <th>Quantity</th>
                    <th>Total (RM)</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($productDetails as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                    <td><?= number_format($item['product_price'], 2) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= number_format($item['total'], 2) ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="product" value="<?= htmlspecialchars($item['product_name']) ?>">
                            <input type="number" name="quantity" value="<?= $item['quantity'] ?>" step="1" min="1">
                            <button type="submit" name="update" class="btn update-btn">Update</button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="product" value="<?= htmlspecialchars($item['product_name']) ?>">
                            <button type="submit" name="remove" class="btn remove-btn">Remove</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" style="text-align:right; font-weight:bold;">Total Price:</td>
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