<?php
// index.php - Main homepage for the AgriMarketplace
session_start();

// Determine last order tracking if available
$lastOrderTracking = '';
if (isset($_SESSION['order_history']) && is_array($_SESSION['order_history']) && count($_SESSION['order_history']) > 0) {
    // Retrieve the last order (assuming orders are appended; using end() gets the last order)
    $lastOrder = end($_SESSION['order_history']);
    $lastOrderTracking = $lastOrder['tracking_number'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>AgriMarketplace - Home</title>
  <link rel="stylesheet" href="style.css"> <!-- Link to external CSS file -->
  <style>
    /* Additional inline CSS for the new reorder button if needed */
    .reorder-btn, .view-vendors-btn {
      display: inline-block;
      padding: 10px 20px;
      background-color: #4caf50;
      color: #fff;
      text-decoration: none;
      border-radius: 6px;
      margin: 20px 0;
      transition: background-color 0.3s ease;
    }
    .reorder-btn:hover, .view-vendors-btn:hover {
      background-color: #388e3c;
    }
  </style>
</head>
<body>
  <header>
    <h1>AgriMarketplace</h1>
  </header>
  
  <main>
    <!-- Introduction Section -->
    <section id="intro">
      <p>This is the digital marketplace where farmers can efficiently market their agricultural products directly to buyers. Choose a category above to explore or list products.</p>
    </section>
    
    <!-- Featured Products Section -->
    <section id="categories">
      <h2>Explore Categories</h2>
      <div class="category-grid">
        <div class="category-card">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSs0cKqLvgSr1jvO-jdV-yZxTtRFG-MEMB8kQ&s" alt="Livestock">
          <a href="livestock.php">Livestock</a>
        </div>
        <div class="category-card">
          <img src="https://i0.wp.com/epthinktank.eu/wp-content/uploads/2014/03/fotolia_55504195_subscription_xxl-web-large.jpg?fit=640%2C425&ssl=1" alt="Crops">
          <a href="crops.php">Crops</a>
        </div>
        <div class="category-card">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTU8G9AbCBIDKCXRLWr1o-vxGU3p9SnF5OQzA&s" alt="Edible Forestry">
          <a href="forestry.php">Edible Forestry</a>
        </div>
        <div class="category-card">
          <img src="https://www.techexplorist.com/wp-content/uploads/2018/10/dairy-products.jpg" alt="Dairy">
          <a href="dairy.php">Dairy</a>
        </div>
        <div class="category-card">
          <img src="https://nutritionsource.hsph.harvard.edu/wp-content/uploads/2024/11/AdobeStock_368767489.jpeg" alt="Fish Farming">
          <a href="fish.php">Fish Farming</a>
        </div>
        <div class="category-card">
          <img src="https://www.shutterstock.com/image-photo/miscellaneous-food-products-including-dairy-260nw-182671874.jpg" alt="Miscellaneous">
          <a href="miscellaneous.php">Miscellaneous</a>
        </div>
      </div>
    </section>

    <!-- Button to view vendors -->
    <section id="view-vendors">
      <h2>View Vendors</h2>
      <p>To explore the vendors available in our marketplace, click the button below:</p>
      <a class="view-vendors-btn" href="customer.php">View Vendors</a>
    </section>

    <?php if ($lastOrderTracking !== ''): ?>
      <section id="reorder">
        <h2>Reorder from your previous order</h2>
        <p>If you'd like to purchase the same items from your last order, click the button below:</p>
        <a class="reorder-btn" href="reorder.php?tracking_number=<?php echo urlencode($lastOrderTracking); ?>">Reorder Last Order</a>
      </section>
    <?php endif; ?>

  </main>
  
  <footer>
    <p>&copy; <?php echo date("Y"); ?> AgriMarketplace. All rights reserved.</p>
  </footer>
</body>
</html>
