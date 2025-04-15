<?php
session_start();
require_once 'service/Checkout.php';
$_SESSION['reorder_items'] = $reorderItems;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f7f7f7; }
        .container { max-width: 1000px; margin: 0 auto; background: #fff; padding: 30px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { padding: 12px 15px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f0f0f0; }
        .total-row td { font-weight: bold; background-color: #f9f9f9; }
        .no-items { padding: 20px; color: red; text-align: center; }
        .confirm-section { margin-top: 30px; }
        .confirm-section label { font-weight: bold; }
        .btn-checkout {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>
    <script>
        function validateCheckout() {
            const checkbox = document.getElementById('confirm_order');
            if (!checkbox.checked) {
                alert('Please confirm your order before proceeding.');
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
<div class="container">
    <h2>Checkout</h2>

    <?php if (count($reorderItems) > 0): ?>
        <form action="payment.php" method="post" onsubmit="return validateCheckout();">
            <table>
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Vendor</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($reorderItems as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['product_name']) ?></td>
                        <td><?= htmlspecialchars($item['vendor_name']) ?></td>
                        <td>$<?= number_format($item['product_price'], 2) ?></td>
                        <td><?= $item['ordered_quantity'] ?></td>
                        <td>$<?= number_format($item['item_total_price'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr class="total-row">
                    <td colspan="4" style="text-align: right;">Subtotal:</td>
                    <td>$<?= number_format($subtotal, 2) ?></td>
                </tr>
                <tr class="total-row">
                    <td colspan="4" style="text-align: right;">Grand Total:</td>
                    <td>$<?= number_format($grand_total, 2) ?></td>
                </tr>
                </tfoot>
            </table>
            <input type="hidden" name="grand_total" value="<?= htmlspecialchars($grand_total) ?>">
            <input type="hidden" name="subtotal" value="<?= htmlspecialchars($subtotal) ?>">
            <div class="confirm-section">
                <label>
                    <input type="checkbox" id="confirm_order" name="confirm_order">
                    I confirm that I want to place this order.
                </label><br>
                <button type="submit" class="btn-checkout">Proceed to Payment</button>
            </div>
        </form>
    <?php else: ?>
        <div class="no-items">No items to checkout.</div>
    <?php endif; ?>
</div>
</body>
</html>
