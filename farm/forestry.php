<?php
// livestock.php: Interactive eMart category page with images and modern UI
session_start();

// Initialize cart array in session if not already set.
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Define products array with consistent keys for all products.
$products = [
    [
        'name' => 'Cashew Nut',
        'price' => 45.00,
        'unit' => 'per kg',
        'description' => 'Locally grown cashew nuts (gajus), rich in healthy fats. Often roasted or used in desserts.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTDeapFyVI6rv8WTVGlCpB-5PLcrIKfvZTI2Q&s'
    ],
    [
        'name' => 'Candlenut (Buah Keras)',
        'price' => 12.00,
        'unit' => 'per kg',
        'description' => 'Essential for Malay/Peranakan cuisine (e.g., rendang). Crushed for thickening curries.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRxGojACPQVSMISDN0lUp1aEDDN3x3BRPcm5Q&s'
    ],
    [
        'name' => 'Coconut (Mature)',
        'price' => 3.50,
        'unit' => 'per piece',
        'description' => 'Used for coconut milk, oil, or grated flesh. Staple in Malaysian cooking.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSthKnE3PhI4CWEUD9SXW14h1362iJo8LZjuA&s'
    ],
    [
        'name' => 'Palm Sugar (Gula Melaka)',
        'price' => 15.00,
        'unit' => 'per kg',
        'description' => 'Traditional palm sugar used in various local dishes.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT0ZzNgs8g19JyN7VzZMyNX_D0-HvUF4ZcFyw&s'
    ],
    [
        'name' => 'Jungle Peanut (Kacang Pangi)',
        'price' => 25.00,
        'unit' => 'per kg',
        'description' => 'Wild-harvested jungle peanuts, full of flavor and nutrients.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRu8ySzBSyroeksn4ZK_1LReT5MT9d7LMVs5Q&s'
    ],
    [
        'name' => 'Almond',
        'price' => 60.00,
        'unit' => 'per kg',
        'description' => 'Raw almonds. Popular for snacks, baking, or almond milk.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTP_HQDxU_PbxYw1ZIMv1mMSXxjv8y4raoemA&s'
    ],
    [
        'name' => 'Walnut',
        'price' => 65.00,
        'unit' => 'per kg',
        'description' => 'Walnuts. Used in baking, salads, or as a health snack.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTjjXBIOgDAlwMir5XxzvOxmpGvN4Zppm8_qw&s'
    ],
    [
        'name' => 'Betel Nut (Pinang)',
        'price' => 8.00,
        'unit' => 'per kg',
        'description' => 'Chewed traditionally with betel leaves. Mild stimulant effect.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTQ-enYJS0xE1xym8Fj5lixn0w_BRCBeXxgqg&s'
    ],
    [
        'name' => 'Sago Palm Starch',
        'price' => 10.00,
        'unit' => 'per kg',
        'description' => 'Starch extracted from sago palm trunks. Used in pearls, cakes, and noodles.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSI59Kbr1RrORhSiex-RS2k0sBxFMnJXoSImA&s'
    ],
    [
        'name' => 'Kemiri Nut',
        'price' => 18.00,
        'unit' => 'per kg',
        'description' => 'Similar to candlenut. Used in Indonesian/Malaysian curries.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTWJwarxwcOLi7M6WqqOLr6kyPyVNhCnYJdog&s'
    ],
];
?>

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livestock Products</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { 
            background: #f9f9f9; 
            font-family: 'Segoe UI', Tahoma, sans-serif; 
            margin: 0; 
            padding: 0; 
        }
        .container { 
            max-width: 1200px; 
            margin: 0 auto; 
            padding: 20px; 
        }
        header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 30px; 
            position: relative;
        }
        .auth-links {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 15px;
            align-items: center;
        }
        .auth-button {
            background-color: #4caf50;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.9em;
            transition: background-color 0.3s;
        }
        .auth-button:hover {
            background-color: #45a049;
        }
        .welcome-message {
            color: #2e7d32;
            font-weight: 500;
            margin-right: 15px;
        }
        .product-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); 
            gap: 20px; 
        }
        .product-card { 
            background: #fff; 
            border-radius: 8px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.1); 
            overflow: hidden; 
            display: flex; 
            flex-direction: column; 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="auth-links">
            <?php if(isset($_SESSION['user'])): ?>
                <span class="welcome-message">Welcome, <?= htmlspecialchars($_SESSION['user']['username']) ?></span>
                <?php if($_SESSION['user']['role'] === 'vendor'): ?>
                    <a href="vendor_dashboard.php" class="auth-button">Vendor Dashboard</a>
                <?php else: ?>
                    <a href="cart.php" class="auth-button">View Cart</a>
                <?php endif; ?>
                <a href="logout.php" class="auth-button">Logout</a>
            <?php else: ?>
                <a href="login.php" class="auth-button">Login</a>
                <a href="register.php" class="auth-button">Register</a>
            <?php endif; ?>
        </div>

        <header>
            <h1>Livestock</h1>
            <a href="index.php" style="
                background-color: #4caf50;
                color: white;
                padding: 10px 20px;
                text-decoration: none;
                border-radius: 6px;
                font-weight: bold;
            ">← Back to Home</a>
            <div class="cart-container">
                <a href="cart.php" class="auth-button">
                    🛒 <span class="cart-count"><?= count($_SESSION['cart']) ?></span>
                </a>
            </div>
        </header>

        <div class="product-grid">
            <?php foreach ($products as $item): ?>
            <div class="product-card">
                <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                <div class="card-content">
                    <h3><?= htmlspecialchars($item['name']) ?></h3>
                    <div class="price">RM <?= number_format($item['price'], 2) ?></div>
                    <div class="unit"><?= htmlspecialchars($item['unit']) ?></div>
                    <div class="description"><?= htmlspecialchars($item['description']) ?></div>
                </div>
                <div class="card-actions">
                    <form class="add-to-cart-form" style="display:flex; width:100%;">
                        <input type="hidden" name="product" value="<?= htmlspecialchars($item['name']) ?>">
                        <input type="hidden" name="price" value="<?= htmlspecialchars($item['price']) ?>">
                        <input type="hidden" name="unit" value="<?= htmlspecialchars($item['unit']) ?>">
                        <input type="number" name="quantity" 
                               min="<?= ($item['unit'] === 'per kg' ? '0.1' : '1') ?>" 
                               value="<?= ($item['unit'] === 'per kg' ? '1' : '1') ?>" 
                               step="<?= ($item['unit'] === 'per kg' ? '0.1' : '1') ?>" 
                               class="quantity-input">
                        <button type="submit" class="add-cart-btn">Add to Cart</button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <div id="toast"></div>
    <script>
        document.querySelectorAll('.add-to-cart-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const data = new FormData(this);
                fetch('cart.php', { method: 'POST', body: data })
                    .then(response => response.text())
                    .then(result => {
                        const countEl = document.querySelector('.cart-count');
                        countEl.textContent = parseInt(countEl.textContent) + 1;
                        showToast(`${data.get('quantity')} ${data.get('unit')} of ${data.get('product')} added to cart.`);
                    })
                    .catch(err => console.error('Error:', err));
            });
        });

        function showToast(message) {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.style.opacity = '1';
            setTimeout(() => { toast.style.opacity = '0'; }, 2500);
        }
    </script>
</body>
</html>