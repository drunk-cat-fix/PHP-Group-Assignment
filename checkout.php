<?php
session_start();
require_once 'service/Checkout.php';
require_once 'nav.php';
$_SESSION['reorder_items'] = $reorderItems;
$_SESSION['grand_total'] = $grand_total;
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f7f7f7; }
        .container { max-width: 900px; margin: auto; padding: 30px; border-radius: 12px; margin-left: 300px; }
        h2 { margin-bottom: 20px; margin-left: 500px}
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; margin-left: 150px}
        th, td { padding: 12px 15px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f0f0f0; }
        .total-row td { font-weight: bold; background-color: #f9f9f9; }
        .no-items { padding: 20px; color: red; text-align: center; }
        .confirm-section { margin-top: 30px; }
        .confirm-section label { font-weight: bold; margin-left: 150px}
        .btn-checkout {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            margin-left: 150px
        }
        .back-to-cart {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #f0f0f0;
            color: #333;
            text-decoration: none;
            border-radius: 4px;
        }
        .payment-methods {
            margin: 20px 0;
            margin-left: 150px
        }
        .payment-methods label {
            display: block;
            margin-bottom: 8px;
        }
        .price-discount {
            color: #e53935;
            font-weight: bold;
        }
        .price-original {
            text-decoration: line-through;
            color: #888;
            font-size: 0.9em;
        }
        .discount-badge {
            background-color: #e53935;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 0.8em;
            margin-left: 5px;
        }
    </style>
    <script>
        function validateCheckout() {
            const checkbox = document.getElementById('confirm_order');
            const paymentMethods = document.getElementsByName('payment_method');
            let methodSelected = false;
            let selectedValue = "";

            for (let i = 0; i < paymentMethods.length; i++) {
                if (paymentMethods[i].checked) {
                    methodSelected = true;
                    selectedValue = paymentMethods[i].value;
                    break;
                }
            }

            if (!methodSelected) {
                alert('Please select a payment method.');
                return false;
            }

            if (!checkbox.checked) {
                alert('Please confirm your order before proceeding.');
                return false;
            }

            // Redirect to selected payment page
            const form = document.getElementById('checkoutForm');
            form.action = selectedValue + '?order_id=<?= urlencode($order_id ?? uniqid("ORD")) ?>';
            return true;
        }
    </script>
</head>
<body>
<div class="container">
    <h2>Checkout</h2>
    <?php if (count($reorderItems) > 0): ?>
        <form id="checkoutForm" method="post" onsubmit="return validateCheckout();">
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
                        <td>
                            <?php if (isset($item['has_promotion']) && $item['has_promotion']): ?>
                                <div class="price-original">RM <?= number_format($item['original_price'], 2) ?></div>
                                <div class="price-discount">
                                    RM <?= number_format($item['product_price'], 2) ?>
                                    <span class="discount-badge"><?= number_format((1 - $item['promotion_factor']) * 100) ?>% OFF</span>
                                </div>
                            <?php else: ?>
                                RM <?= number_format($item['product_price'], 2) ?>
                            <?php endif; ?>
                        </td>
                        <td><?= $item['ordered_quantity'] ?></td>
                        <td>RM <?= number_format($item['item_total_price'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr class="total-row">
                    <td colspan="4" style="text-align: right;">Subtotal:</td>
                    <td>RM <?= number_format($subtotal, 2) ?></td>
                </tr>
                <tr class="total-row">
                    <td colspan="4" style="text-align: right;">Grand Total:</td>
                    <td>RM <?= number_format($grand_total, 2) ?></td>
                </tr>
                </tfoot>
            </table>
            <input type="hidden" name="grand_total" value="<?= htmlspecialchars($grand_total) ?>">
            <input type="hidden" name="subtotal" value="<?= htmlspecialchars($subtotal) ?>">

            <div class="payment-methods">
                <h3>Select Payment Method:</h3>
                <label><input type="radio" name="payment_method" value="payment.php"> Debit/Credit Card</label>
                <label><input type="radio" name="payment_method" value="tng_payment.php"> Touch 'n Go</label>
                <label><input type="radio" name="payment_method" value="bank_transfer_payment.php"> Bank Transfer</label>
            </div>

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
        <a href="cart.php" class="back-to-cart">Back to Cart</a>
    <?php endif; ?>
</div>
</body>
</html>