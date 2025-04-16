<?php
session_start();

// Redirect if cart is empty
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

// Helper to calculate total
function calculateTotal() {
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}

// 1) Handle “Done” click for TNG or Bank (via GET)
if (isset($_GET['action'], $_GET['method']) && $_GET['action'] === 'done') {
    $buyerName = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'Unknown Buyer';
    $total = calculateTotal();
    $totalFormatted = 'RM' . number_format($total, 2);

    $trackingNumber = 'ORD-' . uniqid();
    $order = [
        'tracking_number' => $trackingNumber,
        'items'           => $_SESSION['cart'],
        'total'           => $total,
        'start_time'      => time(),
        'status'          => 'Order Received'
    ];
    $_SESSION['order'] = $order;
    if (!isset($_SESSION['order_history'])) {
        $_SESSION['order_history'] = [];
    }
    $_SESSION['order_history'][] = $order;
    $_SESSION['cart'] = [];

    header("Location: pay_success.php?name=" . urlencode($buyerName) . "&amount=" . urlencode($totalFormatted));
    exit;
}

// 2) Handle Card / TNG / Bank selection submit (via POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $method    = $_POST['method'] ?? '';
    $buyerName = htmlspecialchars($_POST['name'] ?? 'Unknown Buyer');
    $total     = calculateTotal();
    $totalFormatted = 'RM' . number_format($total, 2);

    // — CARD PAYMENT —
    if ($method === 'card') {
        $trackingNumber = 'ORD-' . uniqid();
        $order = [
            'tracking_number' => $trackingNumber,
            'items'           => $_SESSION['cart'],
            'total'           => $total,
            'start_time'      => time(),
            'status'          => 'Order Received',
            'payment_method'  => 'Card'
        ];
        $_SESSION['order'] = $order;
        if (!isset($_SESSION['order_history'])) {
            $_SESSION['order_history'] = [];
        }
        $_SESSION['order_history'][] = $order;
        $_SESSION['cart'] = [];

        header("Location: pay_success.php?name=" . urlencode($buyerName) . "&amount=" . urlencode($totalFormatted));
        exit;
    }

    // — TNG PAYMENT —
    if ($method === 'tng') {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Pay with TNG</title>
            <style>
                body { font-family: 'Segoe UI', sans-serif; background: #f9f9f9; margin: 0; padding: 20px;
                       display: flex; justify-content: center; align-items: center; height: 100vh; }
                .qr-container { background: #fff; padding: 30px; border-radius: 12px;
                                box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; }
                .qr-container img { width: 200px; height: 200px; }
                .done-btn { margin-top: 20px; }
                .done-btn a {
                    background-color: #4caf50; color: white; padding: 10px 20px;
                    text-decoration: none; border-radius: 4px; font-weight: bold;
                }
                .done-btn a:hover { background-color: #388e3c; }
            </style>
        </head>
        <body>
            <div class="qr-container">
                <h2>Scan to Pay with TNG</h2>
                <img src="https://cdn.aptika.com/images/svg/qr-code.svg" alt="TNG QR Code">
                <div class="done-btn">
                    <a href="?action=done&method=tng&name=<?php echo urlencode($buyerName); ?>">Done</a>
                </div>
            </div>
        </body>
        </html>
        <?php
        exit;
    }

    // — BANK TRANSFER —
    if ($method === 'bank') {
        if (!isset($_POST['bank_name'], $_POST['ref_number'], $_POST['transfer_date'])) {
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Bank Transfer</title>
                <style>
                    body { font-family: 'Segoe UI', sans-serif; background: #f9f9f9; margin: 0; padding: 20px;
                           display: flex; justify-content: center; align-items: center; height: 100vh; }
                    .bank-form { background: #fff; padding: 30px; border-radius: 12px;
                                 box-shadow: 0 4px 12px rgba(0,0,0,0.1); max-width: 400px; width: 100%; }
                    .bank-form h2 { text-align: center; color: #2e7d32; }
                    .form-group { margin-bottom: 15px; }
                    label { display: block; margin-bottom: 5px; }
                    input[type="text"], input[type="date"] {
                        width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;
                    }
                    .submit-btn { background-color: #4caf50; color: white; padding: 10px 15px;
                                  border: none; border-radius: 4px; width: 100%; cursor: pointer; }
                    .submit-btn:hover { background-color: #388e3c; }
                </style>
            </head>
            <body>
                <form class="bank-form" method="POST">
                    <h2>Bank Transfer Info</h2>
                    <div class="form-group">
                        <label>Bank Name</label>
                        <input type="text" name="bank_name" required>
                    </div>
                    <div class="form-group">
                        <label>Transaction Reference No.</label>
                        <input type="text" name="ref_number" required>
                    </div>
                    <div class="form-group">
                        <label>Transfer Date</label>
                        <input type="date" name="transfer_date" required>
                    </div>
                    <input type="hidden" name="method" value="bank">
                    <input type="hidden" name="name" value="<?= htmlspecialchars($buyerName) ?>">
                    <button type="submit" class="submit-btn">Submit</button>
                </form>
            </body>
            </html>
            <?php
            exit;
        } else {
            $bankName = htmlspecialchars($_POST['bank_name']);
            $refNo = htmlspecialchars($_POST['ref_number']);
            $transferDate = htmlspecialchars($_POST['transfer_date']);

            $trackingNumber = 'ORD-' . uniqid();
            $order = [
                'tracking_number' => $trackingNumber,
                'items'           => $_SESSION['cart'],
                'total'           => $total,
                'start_time'      => time(),
                'status'          => 'Order Received',
                'payment_method'  => 'Bank Transfer',
                'bank_details'    => [
                    'bank_name'     => $bankName,
                    'ref_number'    => $refNo,
                    'transfer_date' => $transferDate
                ]
            ];
            $_SESSION['order'] = $order;
            if (!isset($_SESSION['order_history'])) {
                $_SESSION['order_history'] = [];
            }
            $_SESSION['order_history'][] = $order;
            $_SESSION['cart'] = [];

            header("Location: pay_success.php?name=" . urlencode($buyerName) . "&amount=" . urlencode($totalFormatted));
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f9f9f9; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: auto; background: #fff; padding: 30px;
                     border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #2e7d32; }
        .order-summary { margin: 20px 0; }
        .order-item { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .total { font-weight: bold; font-size: 1.2em; margin-top: 20px;
                 padding-top: 10px; border-top: 1px solid #ccc; }
        .payment-form { margin-top: 30px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"] { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .pay-btn { background-color: #4caf50; color: white; padding: 10px 15px;
                   border: none; border-radius: 4px; cursor: pointer; width: 100%; }
        .pay-btn:hover { background-color: #388e3c; }
        .method-group label { margin-right: 15px; }
    </style>
    <script>
        function toggleFields() {
            var method = document.querySelector('input[name="method"]:checked').value;
            document.getElementById('card-fields').style.display = (method === 'card') ? 'block' : 'none';
        }
        window.onload = toggleFields;
    </script>
</head>
<body>
    <div class="container">
        <h1>Payment</h1>
        <div class="order-summary">
            <h3>Order Summary</h3>
            <?php foreach ($_SESSION['cart'] as $item): ?>
                <div class="order-item">
                    <span><?= htmlspecialchars($item['product']) ?> (<?= $item['quantity'] ?> <?= htmlspecialchars($item['unit']) ?>)</span>
                    <span>RM <?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                </div>
            <?php endforeach; ?>
            <div class="total">
                Total: RM <?= number_format(calculateTotal(), 2) ?>
            </div>
        </div>

        <form class="payment-form" method="POST">
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group method-group">
                <label><input type="radio" name="method" value="card" checked onchange="toggleFields()"> Card</label>
                <label><input type="radio" name="method" value="tng" onchange="toggleFields()"> TNG</label>
                <label><input type="radio" name="method" value="bank" onchange="toggleFields()"> Bank Transfer</label>
            </div>

            <div id="card-fields">
                <div class="form-group">
                    <label for="card">Card Number</label>
                    <input type="text" id="card" name="card">
                </div>
                <div class="form-group">
                    <label for="expiry">Expiry Date</label>
                    <input type="text" id="expiry" name="expiry" placeholder="MM/YY">
                </div>
                <div class="form-group">
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" name="cvv">
                </div>
            </div>

            <button type="submit" class="pay-btn">Proceed</button>
        </form>
    </div>
</body>
</html>
