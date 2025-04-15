<?php
// livestock.php: Interactive eMart Livestock category page with images and modern UI
session_start();

// Initialize cart array in session if not already set.
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Define products array
$products = [
    ['name'=>'Egg (Type A)','price'=>19,'unit'=>'per tray','description'=>'Premium free-range eggs with sturdy shells and rich yolks. Contains 30 pieces per tray.','image'=>'https://www.bohming.com.my/wp-content/uploads/2019/11/30eggspertray.jpg'],
    ['name'=>'Egg (Type B)','price'=>15,'unit'=>'per tray','description'=>'Fresh farm eggs with balanced nutrition. Contains 30 pieces per tray.','image'=>'https://www.bohming.com.my/wp-content/uploads/2019/11/30eggspertray.jpg'],
    ['name'=>'Egg (Type C)','price'=>13,'unit'=>'per tray','description'=>'Budget-friendly eggs suitable for bulk culinary needs. Contains 30 pieces per tray.','image'=>'https://www.bohming.com.my/wp-content/uploads/2019/11/30eggspertray.jpg'],
    ['name'=>'Chicken (bone)','price'=>16,'unit'=>'per kg','description'=>'Fresh bone-in chicken with firm texture, excellent for soups or slow-cooked dishes.','image'=>'https://cdn.shopaccino.com/gtgroceries/products/fresh-chicken-with-bones-1kg-853572_l.jpg?v=523.jpg'],
    ['name'=>'Chicken (boneless)','price'=>21,'unit'=>'per kg','description'=>'Tender boneless chicken breast/leg meat, low-fat and high-protein.','image'=>'https://hongsengcoldstorage.com/490-large_default/chicken-boneless-breast-2kgpkt.jpg'],
    ['name'=>'Duck','price'=>19.5,'unit'=>'per kg','description'=>'Locally raised duck with well-distributed fat, perfect for roasting or braising.','image'=>'https://www.mybutchermarket.com/image/cache/cache/1-1000/122/main/c55d-depositphotos_122376338-stock-photo-raw-whole-duck-0-1-500x500.jpg'],
    ['name'=>'Duck egg','price'=>25,'unit'=>'per tray','description'=>'Large duck eggs with creamy yolks. Contains 20 pieces per tray.','image'=>'https://yongsooneggs.com.my/wp-content/uploads/2018/08/blown-duck-eggs-1_02.jpg'],
    ['name'=>'Pork belly','price'=>30,'unit'=>'per kg','description'=>'Marbled pork belly, excellent for braised dishes or barbecue.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTcDHw7oRzsy6m2W76WsM7VsMhOtnnq0y075g&s'],
    ['name'=>'Pork meat','price'=>24.5,'unit'=>'per kg','description'=>'Lean pork cuts, low in cholesterol, suitable for stir-fries.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQSRUWdA5JzcJmFBJzEnXVDLgFLyerSxGV9LA&s'],
    ['name'=>'Beef','price'=>36,'unit'=>'per kg','description'=>'Malaysia beef, tender and juicy, perfect for steaks or stir-fries.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRXIL9wHYieWDZgv5aQzh7FhPa09NNLCToFVA&s'],
    ['name'=>'Mutton','price'=>37,'unit'=>'per kg','description'=>'Grass-fed lamb, mild flavour with no gaminess.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGi83bMSVXxM41Jj_Q4XETUM3lBOTxwDUvow&s'],
];

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