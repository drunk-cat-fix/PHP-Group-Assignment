<?php
// dairy.php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dairy Products</title>
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
        .card-content {
            padding: 15px;
        }
        .card-content h3 {
            margin: 0 0 10px 0;
            color: #2e7d32;
        }
        .price {
            font-weight: bold;
            font-size: 1.1em;
            color: #2196f3;
        }
        .unit {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 10px;
        }
        .description {
            color: #444;
            font-size: 0.9em;
            line-height: 1.4;
            height: 60px;
            overflow: hidden;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.8);
        }
        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 30px;
            border-radius: 12px;
            width: 80%;
            max-width: 700px;
            position: relative;
            animation: modalOpen 0.3s;
        }
        @keyframes modalOpen {
            from {opacity: 0; transform: translateY(-20px);}
            to {opacity: 1; transform: translateY(0);}
        }
        .close {
            position: absolute;
            right: 25px;
            top: 15px;
            color: #aaa;
            font-size: 32px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover {
            color: #666;
        }
        .modal-details {
            margin-top: 20px;
            line-height: 1.6;
        }
        .modal-details p {
            margin: 15px 0;
        }
        .view-details-btn {
            background-color: #2196f3;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            width: 100%;
            transition: background-color 0.3s;
        }
        .view-details-btn:hover {
            background-color: #1976d2;
        }
        .card-actions {
            display: flex;
            gap: 10px;
            padding: 15px;
            margin-top: auto;
        }
        .quantity-input {
            flex: 1;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .add-cart-btn {
            background-color: #4caf50;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .add-cart-btn:hover {
            background-color: #45a049;
        }
        #toast {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: white;
            padding: 12px 24px;
            border-radius: 4px;
            opacity: 0;
            transition: opacity 0.3s;
            z-index: 1000;
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
            <h1>Dairy Products</h1>
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
                <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="width: 100%; height: 200px; object-fit: cover;">
                <div class="card-content">
                    <h3><?= htmlspecialchars($item['name']) ?></h3>
                    <div class="price">RM <?= number_format($item['price'], 2) ?></div>
                    <div class="unit"><?= htmlspecialchars($item['unit']) ?></div>
                    <div class="description"><?= htmlspecialchars($item['description']) ?></div>
                </div>
                <div class="card-actions">
                    <button type="button" class="view-details-btn" 
                        onclick="showProductDetails(
                            '<?= htmlspecialchars($item['name']) ?>',
                            <?= $item['price'] ?>,
                            '<?= htmlspecialchars($item['unit']) ?>',
                            '<?= htmlspecialchars($item['description']) ?>',
                            '<?= htmlspecialchars($item['image']) ?>'
                        )">
                        View Details
                    </button>
                    <form class="add-to-cart-form" style="display:flex; flex:1;">
                        <input type="hidden" name="product" value="<?= htmlspecialchars($item['name']) ?>">
                        <input type="hidden" name="price" value="<?= htmlspecialchars($item['price']) ?>">
                        <input type="hidden" name="unit" value="<?= htmlspecialchars($item['unit']) ?>">
                        <input type="number" name="quantity" 
                            min="<?= ($item['unit'] === 'per kg' ? '0.1' : '1') ?>" 
                            value="<?= ($item['unit'] === 'per kg' ? '1' : '1') ?>" 
                            step="<?= ($item['unit'] === 'per kg' ? '0.1' : '1') ?>" 
                            class="quantity-input">
                        <button type="submit" class="add-cart-btn">Add</button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Product Details Modal -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img id="modalImage" src="" alt="Product Image" style="max-width: 300px; margin-bottom: 20px;">
            <h2 id="modalTitle"></h2>
            <div class="modal-details">
                <p><strong>Price:</strong> RM <span id="modalPrice"></span> (<span id="modalUnit"></span>)</p>
                <p id="modalDescription"></p>
            </div>
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

        // Modal functionality
        const modal = document.getElementById('productModal');
        const span = document.getElementsByClassName("close")[0];

        function showProductDetails(name, price, unit, description, image) {
            document.getElementById('modalTitle').textContent = name;
            document.getElementById('modalPrice').textContent = price.toFixed(2);
            document.getElementById('modalUnit').textContent = unit;
            document.getElementById('modalDescription').textContent = description;
            document.getElementById('modalImage').src = image;
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>