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
        'name' => 'Wild Tualang Honey',  
        'price' => 120.00,  
        'unit' => 'per kg',  
        'description' => 'Raw honey harvested from wild Tualang trees. Prized for medicinal properties.',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSV3QRK66GTceC_wCm4StO5VBvutsLH4f84Dg&s'  
    ],  
    [  
        'name' => 'Stingless Bee Honey (Madu Kelulut)',  
        'price' => 150.00,  
        'unit' => 'per 500ml',  
        'description' => 'Tart, nutrient-rich honey from kelulut bees. Popular for health-conscious consumers.',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSRpxqve8oSDcd20eJ67DQC2NdqSWPiwbzzUA&s'  
    ],  
    [  
        'name' => 'Coconut Oil (Virgin)',  
        'price' => 25.00,  
        'unit' => 'per 500ml',  
        'description' => 'Cold-pressed coconut oil for cooking, skincare, or haircare.',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQDCV52br_RzeVLgLCTl6glnlShHCTphluqRw&s'  
    ],  
    [  
        'name' => 'Palm Vinegar (Cuka Aren)',  
        'price' => 12.00,  
        'unit' => 'per bottle',  
        'description' => 'Fermented vinegar from palm sap, used in salads or traditional dishes.',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTkktHzcDhOAGGeSnBluXg7vbT67z5A5kIk_g&s'  
    ],  
    [  
        'name' => 'Bird’s Nest (Edible)',  
        'price' => 3000.00,  
        'unit' => 'per 100g',  
        'description' => 'Premium cleaned swiftlet nests, used in soups or desserts for collagen.',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS4NmdJCjf2_6C4F8rwix1c-NMwEjM10idHGA&s'  
    ],  
    [  
        'name' => 'Dried Lemongrass (Serai)',  
        'price' => 8.00,  
        'unit' => 'per 100g',  
        'description' => 'Sun-dried lemongrass stalks for teas, soups, or curry pastes.',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRp14Ve0F7dkFndkRUuB1KNSJ9UeungRduNqA&s'  
    ],  
    [  
        'name' => 'Sago Pearls',  
        'price' => 5.00,  
        'unit' => 'per 500g',  
        'description' => 'Starch pearls from sago palms, used in desserts like *sago gula Melaka*.',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTW4-QC1A9uTqs0TWCD9Ija-dS_itmbRd_IeQ&s'  
    ],  
    [  
        'name' => 'Nipah Palm Sugar (Gula Apong)',  
        'price' => 20.00,  
        'unit' => 'per kg',  
        'description' => 'Artisanal sugar from nipah palm sap, popular in Sarawak.',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQCLr8QywRoxAF3m_xIlRn6OAMKgUrj_6L2ag&s'  
    ],  
    [  
        'name' => 'Roselle Flower (Asam Paya)',  
        'price' => 10.00,  
        'unit' => 'per 100g',  
        'description' => 'Dried roselle calyces for making tangy teas or jams.',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSnHmLOEJ1tEQC7gqaxYO7FMpxA9RPqqWPfiw&s'  
    ],  
    [  
        'name' => 'Bamboo Salt',  
        'price' => 40.00,  
        'unit' => 'per 200g',  
        'description' => 'Salt roasted in bamboo, believed to have detoxifying benefits.',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRW1Uc6ih8DpZgHgXXwbwKm3L2SSaav8vHznA&s'  
    ],  
    [  
        'name' => 'Cinnamon Bark (Kayu Manis)',  
        'price' => 18.00,  
        'unit' => 'per 100g',  
        'description' => 'Locally sourced cinnamon sticks for curries, drinks, or desserts.',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSVGddw4ecG9_lrHXHEoSERg_KS6CZKZl-n_w&s'  
    ],  
];  

// Notes:  
// - **Honey**: Wild Tualang and kelulut honey are luxury products due to labor-intensive harvesting.  
// - **Bird’s Nest**: Prices vary widely based on grade (cleanliness and origin).  
// - **Ethnic Specialties**: Nipah sugar (Sarawak) and bamboo salt (traditional Korean-Malaysian fusion).  
// - **Certifications**: Organic or halal certifications may increase prices.  
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