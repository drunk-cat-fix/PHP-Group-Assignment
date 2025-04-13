<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>AgriMarketplace - Home</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .auth-links {
      position: absolute;
      top: 20px;
      right: 20px;
      display: flex;
      gap: 15px;
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
    .vendor-panel {
      margin: 20px;
      padding: 15px;
      background-color: #f0f0f0;
      border-radius: 6px;
    }
    .category-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      padding: 20px;
    }
    .category-card {
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 15px;
      text-align: center;
      transition: transform 0.3s;
    }
    .category-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .category-card img {
      max-width: 200px;
      height: 150px;
      object-fit: cover;
      border-radius: 4px;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <header>
    <h1>Crops Marketplace</h1>
    <div class="auth-links">
      <?php if(isset($_SESSION['user'])): ?>
        <span style="color: #2e7d32;">Welcome, <?= htmlspecialchars($_SESSION['user']['username']) ?></span>
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
    
    <div style="margin: 20px;">
      <a href="index.php" style="
          background-color: #4caf50;
          color: white;
          padding: 10px 20px;
          text-decoration: none;
          border-radius: 6px;
          font-weight: bold;
      ">← Back to Home</a>
    </div>
  </header>

  <main>
    <?php if(isset($_SESSION['user']) && $_SESSION['user']['role'] === 'vendor'): ?>
      <section class="vendor-panel">
        <h3>Vendor Controls</h3>
        <p>Manage your products and inventory through the vendor dashboard.</p>
        <a href="vendor_dashboard.php" class="auth-button">Manage Products</a>
      </section>
    <?php endif; ?>

    <section id="intro">
      <p>This is the digital marketplace where farmers can efficiently market their agricultural products directly to buyers. Choose a category below to explore products.</p>
    </section>
    
    <section id="categories">
      <h2>Explore Categories</h2>
      <div class="category-grid">
        <div class="category-card">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTpX1Ut5eFtME_JjgpQhH89wDito-zZiVo4Kw&s" alt="Fruits">
          <a href="fruit.php" class="auth-button">Fruits</a>
        </div>
        <div class="category-card">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRncPN-yo0zkVBeykxzbhRkDyCrtjNm7AxJUQ&s" alt="Vegetables">
          <a href="vegetable.php" class="auth-button">Vegetables</a>
        </div>
      </div>
    </section>
  </main>

  <footer>
    <p>&copy; <?php echo date("Y"); ?> AgriMarketplace. All rights reserved.</p>
  </footer>
</body>
</html>