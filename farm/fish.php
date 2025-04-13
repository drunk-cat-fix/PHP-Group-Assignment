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
        'name' => 'Red Tilapia',  
        'price' => 18.00,  
        'unit' => 'per kg',  
        'description' => 'Freshwater fish, fast-growing and popular for grilling or steaming. Farmed in ponds.',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRAfqjJsv2rRz0zQvlxVSSw60XFXy_pz6hMzg&s'  
    ],  
    [  
        'name' => 'Catfish (Ikan Keli)',  
        'price' => 12.00,  
        'unit' => 'per kg',  
        'description' => 'Hardy freshwater catfish, often deep-fried or cooked in curries.',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRqxUF_33mDOjVATVW66DdH2GWjG-Uq6lfvTQ&s'  
    ],  
    [  
        'name' => 'Sea Bass (Siakap)',  
        'price' => 35.00,  
        'unit' => 'per kg',  
        'description' => 'Saltwater fish farmed in cages. Prized for its firm, white flesh.',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ0R3bUb3RXbbk_aCX9lkmKKMmiPBfxpWkg0A&s'  
    ],  
    [  
        'name' => 'Grouper (Kerapu)',  
        'price' => 60.00,  
        'unit' => 'per kg',  
        'description' => 'High-value marine fish, often exported live to restaurants.',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR34RXKSS0Tw4AdZ3E4XgZLQmlfA0lAm8jH3Q&s'  
    ],  
    [  
        'name' => 'Freshwater Prawn (Udang Galah)',  
        'price' => 45.00,  
        'unit' => 'per kg',  
        'description' => 'Large freshwater prawns, farmed in ponds. Sweet and succulent.',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQKslDyQ-dKrrdjdD0HR0BKXtV5TWKllCYVZw&s'  
    ],  
    [  
        'name' => 'Tiger Prawn (Udang Harimau)',  
        'price' => 55.00,  
        'unit' => 'per kg',  
        'description' => 'Brackish-water prawns, premium quality for stir-fries or grilling.',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQAmVBta2uVoTUA9EOJINEqLmdQEdBXnMJStA&s'  
    ],  
    [  
        'name' => 'Patin Fish',  
        'price' => 20.00,  
        'unit' => 'per kg',  
        'description' => 'Local favorite for soups (e.g., *asam pedas*). Farmed in rivers or ponds.',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS168zdDvMXh9YwSkRmD3rmsgbSod-6HjfOGA&s'  
    ],  
    [  
        'name' => 'Silver Pomfret (Bawal Putih)',  
        'price' => 70.00,  
        'unit' => 'per kg',  
        'description' => 'Premium marine fish, often steamed whole for special occasions.',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQQc_T4_fiQuBcOnrdiluuws13DfIXUE6kSgw&s'  
    ],  
    [  
        'name' => 'Fish Fry (Tilapia)',  
        'price' => 0.50,  
        'unit' => 'per piece',  
        'description' => 'Juvenile tilapia for pond stocking. Sold in bulk to fish farmers.',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ5B6HPivarDY2FcbHNxsF1L9582NU4WlzCXQ&s'  
    ],  
    [  
        'name' => 'Sturgeon (Caviar Production)',  
        'price' => 300.00,  
        'unit' => 'per kg',  
        'description' => 'Niche aquaculture product for luxury caviar. Farmed in controlled systems.',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRm7gYLk4uuj48SVtu4WtyLvUv1ShqBUotmAg&s'  
    ],  
    [  
        'name' => 'Fish Fillets (Frozen)',  
        'price' => 25.00,  
        'unit' => 'per kg',  
        'description' => 'Processed tilapia or seabass fillets, ready for export or retail.',  
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRNHZtzoosH0jUdCxvPXeyIDl3RFhrBdrSjqg&s'  
    ],  
];  

// Notes:  
// - **Freshwater vs. Marine**: Tilapia, catfish, and patin are pond-farmed; seabass and grouper require brackish/saltwater.  
// - **Export Focus**: Grouper and prawns are major export products.  
// - **Sustainability**: Fish like tilapia are bred for fast growth, reducing pressure on wild stocks.  
// - **Prices**: Vary by size (e.g., large live grouper can exceed RM100/kg).  
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