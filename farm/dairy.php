<?php
// livestock.php: Interactive eMart Livestock category page with images and modern UI
session_start();

// Initialize cart array in session if not already set.
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Define products array
$products = [  
    [  
        'name' => 'Fresh Cow Milk (Local)',  
        'price' => 8.50,  
        'unit' => 'per liter',  
        'description' => 'Pasteurized fresh milk from Malaysian dairy farms (e.g., Fernleaf, Farm Fresh).',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRhy7UQnn3ZitLOVdAqiLbFBUieKoiN5G7jag&s'  
    ],  
    [  
        'name' => 'Butter (Salted)',  
        'price' => 12.00,  
        'unit' => 'per 250g',  
        'description' => 'Imported salted butter (e.g., Anchor, President) or local brands like SCS.',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSQEusULkU7BFvwkz35fKOHKMDt1-ISqegKag&s'  
    ],  
    [  
        'name' => 'Cheese Slices',  
        'price' => 15.00,  
        'unit' => 'per 200g',  
        'description' => 'Processed cheese slices (Kraft, Perfect Italiano) for sandwiches and burgers.',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTak5NUXDEjWuz2J5uA2zfgQP-lG2_Xq3rtFA&s'  
    ],  
    [  
        'name' => 'Yogurt (Plain)',  
        'price' => 10.00,  
        'unit' => 'per 500ml',  
        'description' => 'Local or imported plain yogurt (Marigold, Nestlé). Used in drinks or desserts.',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQVpkO4y-qnO1Gkp3ZQrZdK1SJ9Bo4wqRkgZA&s'  
    ],  
    [  
        'name' => 'Condensed Milk',  
        'price' => 6.50,  
        'unit' => 'per 395g can',  
        'description' => 'Sweetened condensed milk (Carnation, F&N) for teas, desserts, or *teh tarik*.',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSOTnl48LxEo1Mm5g2-WU2UxBNM9GV_EGA0pw&s'  
    ],  
    [  
        'name' => 'Ice Cream (Tub)',  
        'price' => 25.00,  
        'unit' => 'per 2L',  
        'description' => 'Local brands like Walls or international options (Baskin Robbins, Häagen-Dazs).',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzMKiSWzBdsPT1TA2iMinbhH_kGW_r1qBpaQ&s'  
    ],  
    [  
        'name' => 'Evaporated Milk',  
        'price' => 5.00,  
        'unit' => 'per 410g can',  
        'description' => 'Used in Malaysian desserts and coffee (e.g., Ideal, F&N).',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTMM51Ww7FB578nr5uQM8BGqBvEqlD0yjAA9Q&s'  
    ],    
    [  
        'name' => 'Ghee (Clarified Butter)',  
        'price' => 35.00,  
        'unit' => 'per 1kg',  
        'description' => 'Used in Indian/Mamak cuisine for cooking or baking.',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQkH8eROcEVWl3FdtYI7yXzEEsgh7bCDNwYcw&s'  
    ],   
];  

// Notes:  
// - **Local brands**: Farm Fresh, Fernleaf, and Marigold are popular Malaysian dairy producers.  
// - **Imported dominance**: Most butter, cheese, and specialty products are imported (prices reflect import taxes).  
// - **Halal focus**: All products are halal-certified to cater to Malaysia’s majority-Muslim population.  
// - **Condensed/evaporated milk**: Integral to Malaysian beverages like *teh tarik* and *kopi*.   
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
        /* ... (other existing styles remain unchanged) ... */
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