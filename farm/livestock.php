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