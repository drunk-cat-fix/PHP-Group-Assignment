<?php
// index.php - Main homepage for the AgriMarketplace

// Optional: include header and common functions
// include('header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>AgriMarketplace - Home</title>
  <link rel="stylesheet" href="style.css"> <!-- Link to external CSS file -->
  
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
  </main>
  
  <footer>
    <p>&copy; <?php echo date("Y"); ?> AgriMarketplace. All rights reserved.</p>
  </footer>
</body>
</html>
