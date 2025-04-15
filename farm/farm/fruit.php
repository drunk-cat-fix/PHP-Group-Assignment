<?php
session_start();

// Initialize cart array in session if not already set.
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Define products array
$products = [
    ['name'=>'Durian','price'=>30,'unit'=>'per kg','description'=>'Known as the "King of Fruits", has a strong smell and creamy, rich flesh.','image'=>'https://th-thumbnailer.cdn-si-edu.com/lRYhWEjayG12jDi1HF83beW7eyw=/fit-in/1600x0/https://tf-cmsv2-smithsonianmag-media.s3.amazonaws.com/filer/a3/08/a308890c-0ee2-43dd-9337-ac562bf82dc3/1200px-durian.jpg'],
    ['name'=>'Mangosteen','price'=>10,'unit'=>'per kg','description'=>'Sweet and tangy with a thick purple rind, known as the "Queen of Fruits".','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ2fFR54BeuXPu-hXgCD8-bdMRi0vjyAwpdIA&s'],
    ['name'=>'Rambutan','price'=>8,'unit'=>'per kg','description'=>'Hairy red fruit with juicy, translucent white flesh.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQt1wwwgWU7eWYL1zpHeprkQQNz7brB8JrhtQ&s'],
    ['name'=>'Papaya','price'=>3.5,'unit'=>'per kg','description'=>'Orange-fleshed tropical fruit, mildly sweet, often eaten fresh or in juices.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSG23rWE6JUuWPv5RYGIqwett_Ndv5WPvSqww&s'],
    ['name'=>'Banana (Pisang)','price'=>4,'unit'=>'per kg','description'=>'Grown in bunches, sweet and commonly eaten raw or fried.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcToRc2zBF_HnwZev33FgkwuqCUj__J23prJ-g&s'],
    ['name'=>'Watermelon','price'=>2.8,'unit'=>'per kg','description'=>'Large, juicy fruit with red or yellow flesh, perfect for hot weather.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRkC9-gGDFMzd9VwfEixEP7QV5KVP5NCFrl8A&s'],
    ['name'=>'Pineapple (Nanas)','price'=>3.2,'unit'=>'per kg','description'=>'Tart and sweet fruit with spiky skin, used in juices and dishes.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ5qjsBDUuEVUVWabyaPUsx6LD52xmkub5YDQ&s'],
    ['name'=>'Starfruit (Belimbing)','price'=>5,'unit'=>'per kg','description'=>'Star-shaped fruit, crunchy texture with mildly tangy flavor.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRvaGnrxVaaAZ1QZnSbvJoL_PMLl2UiYQXcHQ&s'],
    ['name'=>'Guava (Jambu Batu)','price'=>4.5,'unit'=>'per kg','description'=>'Crisp and mildly sweet, can be eaten raw or juiced.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcREwlqWZwMIJYbDL8JjTJyjgjmHetyXISLNjQ&s'],
    ['name'=>'Jackfruit (Nangka)','price'=>6.5,'unit'=>'per kg','description'=>'Large fruit with sweet yellow pods, often eaten fresh or cooked.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSY6uWuVom5_aQ-_Lyeg_EqR-OhP4OOBHSdjQ&s'],
    ['name'=>'Cempedak','price'=>8,'unit'=>'per kg','description'=>'Similar to jackfruit, with stronger aroma and softer texture.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQqGGuehoAgdApTlG6hS8l65GFfpDN-mVR3VQ&s'],
    ['name'=>'Langsat','price'=>7,'unit'=>'per kg','description'=>'Small round fruit, sweet and slightly bitter, popular in rural markets.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQeFlqWdEMvuD2KOqsTRUs0DoByPwHpQ3xfjw&s'],
    ['name'=>'Dragon Fruit','price'=>9,'unit'=>'per kg','description'=>'Bright pink or yellow skin with white/red flesh, mildly sweet and refreshing.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQQuoQXQcNi3kq6F5pYqcClMhoWhOZu_KcwvQ&s'],
    ['name'=>'Mango (Mangga)','price'=>5,'unit'=>'per kg','description'=>'Juicy and sweet, grown locally in many varieties like Harumanis and Chokanan.','image'=>'data:image/jpeg;base64,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'],
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fruit Products</title>
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
            <h1>Fruit</h1>
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