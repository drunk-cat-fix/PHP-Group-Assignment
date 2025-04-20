<?php
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}
require_once 'nav_logic.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #4CAF50;
            --primary-dark: #388E3C;
            --primary-light: #C8E6C9;
            --accent-color: #FF5722;
            --text-light: #FFFFFF;
            --text-dark: #333333;
            --gray-light: #F5F5F5;
            --gray-medium: #E0E0E0;
            --gray-dark: #9E9E9E;
            --danger: #F44336;
            --success: #4CAF50;
            --warning: #FFC107;
            --info: #2196F3;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
            --shadow-md: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
            --shadow-lg: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
        }
        
        .header {
            background-color: var(--primary-color);
            padding: 0.5rem 1rem;
            box-shadow: var(--shadow-md);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        nav {
            position: relative;
            z-index: 999;
        }
        
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-light);
        }
        
        .logo i {
            margin-right: 10px;
            font-size: 1.8rem;
        }
        
        .nav-menu {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            transition: var(--transition);
        }
        
        .nav-item {
            position: relative;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            color: var(--text-light);
            text-decoration: none;
            padding: 1rem 1.2rem;
            transition: var(--transition);
            font-weight: 500;
            font-size: 1rem;
        }
        
        .nav-link:hover {
            background-color: var(--primary-dark);
        }
        
        .nav-link i {
            margin-right: 6px;
        }
        
        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 200px;
            background-color: var(--text-light);
            box-shadow: var(--shadow-md);
            border-radius: 4px;
            overflow: hidden;
            display: none;
            z-index: 1;
        }
        
        .nav-item:hover .dropdown-menu {
            display: block;
        }
        
        .dropdown-item {
            display: block;
            color: var(--text-dark);
            padding: 0.75rem 1rem;
            text-decoration: none;
            transition: var(--transition);
        }
        
        .dropdown-item:hover {
            background-color: var(--gray-light);
            color: var(--primary-color);
        }
        
        .user-menu {
            display: flex;
            align-items: center;
        }
        
        .cart-icon, .notification-icon {
            position: relative;
            margin-right: 1.5rem;
        }
        
        .cart-icon .badge, .notification-icon .badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--danger);
            color: var(--text-light);
            font-size: 0.7rem;
            font-weight: 700;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .cart-link, .notification-link {
            color: var(--text-light);
            font-size: 1.2rem;
            text-decoration: none;
            transition: var(--transition);
        }
        
        .cart-link:hover, .notification-link:hover {
            color: var(--primary-light);
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            cursor: pointer;
            position: relative;
        }
        
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-light);
            transition: var(--transition);
        }
        
        .avatar:hover {
            transform: scale(1.05);
            border-color: var(--text-light);
        }
        
        .user-name {
            color: var(--text-light);
            margin-left: 10px;
            font-weight: 500;
            display: none;
        }
        
        @media (min-width: 768px) {
            .user-name {
                display: block;
            }
        }
        
        .user-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background-color: var(--text-light);
            box-shadow: var(--shadow-md);
            border-radius: 4px;
            width: 200px;
            z-index: 100;
            margin-top: 10px;
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        
        .user-dropdown.active {
            display: block;
            visibility: visible;
            opacity: 1;
        }
        
        .user-dropdown-header {
            padding: 1rem;
            border-bottom: 1px solid var(--gray-medium);
            text-align: center;
        }
        
        .user-dropdown-name {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 5px;
        }
        
        .user-dropdown-role {
            font-size: 0.8rem;
            color: var(--gray-dark);
        }
        
        .user-dropdown-item {
            display: flex;
            align-items: center;
            color: var(--text-dark);
            padding: 0.75rem 1rem;
            text-decoration: none;
            transition: var(--transition);
        }
        
        .user-dropdown-item:hover {
            background-color: var(--gray-light);
            color: var(--primary-color);
        }
        
        .user-dropdown-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .user-dropdown-divider {
            height: 1px;
            background-color: var(--gray-medium);
            margin: 0.5rem 0;
        }
        
        .logout-btn {
            display: block;
            width: 100%;
            padding: 0.75rem;
            text-align: center;
            border: none;
            background-color: var(--danger);
            color: var(--text-light);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            border-radius: 0 0 4px 4px;
        }
        
        .logout-btn:hover {
            background-color: #d32f2f;
        }
        
        .hamburger {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            color: var(--text-light);
            font-size: 1.5rem;
        }
        
        @media (max-width: 992px) {
            .hamburger {
                display: block;
            }
            
            .nav-menu {
                position: fixed;
                top: 60px;
                left: -100%;
                flex-direction: column;
                background-color: var(--primary-color);
                width: 280px;
                height: calc(100vh - 60px);
                box-shadow: var(--shadow-lg);
                transition: 0.3s;
                overflow-y: auto;
            }
            
            .nav-menu.active {
                left: 0;
            }
            
            .nav-item {
                width: 100%;
            }
            
            .dropdown-menu {
                position: static;
                width: 100%;
                box-shadow: none;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease-out;
                display: block;
                background-color: var(--primary-dark);
                border-radius: 0;
            }
            
            .nav-item.active .dropdown-menu {
                max-height: 1000px;
            }
            
            .dropdown-item {
                color: var(--text-light);
                padding-left: 2rem;
            }
            
            .dropdown-item:hover {
                background-color: rgba(255, 255, 255, 0.1);
                color: var(--text-light);
            }
            
            .nav-link {
                justify-content: space-between;
            }
            
            .nav-link::after {
                content: '\f107';
                font-family: 'Font Awesome 5 Free';
                font-weight: 900;
                transition: var(--transition);
            }
            
            .nav-item.active .nav-link::after {
                transform: rotate(180deg);
            }
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        
        .modal.active {
            display: flex;
            visibility: visible;
            opacity: 1;
        }
        
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            position: relative;
            max-width: 90%;
            width: 400px;
            box-shadow: var(--shadow-lg);
        }
        
        .modal-content h3 {
            margin-bottom: 20px;
            color: var(--text-dark);
        }
        
        .modal img {
            max-width: 100%;
            max-height: 300px;
            border-radius: 5px;
            object-fit: contain;
            margin-bottom: 20px;
        }
        
        .modal-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        
        .modal-btn {
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .upload-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
        }
        
        .upload-btn:hover {
            background-color: var(--primary-dark);
        }
        
        .cancel-btn {
            background-color: var(--gray-light);
            color: var(--text-dark);
            border: 1px solid var(--gray-medium);
        }
        
        .cancel-btn:hover {
            background-color: var(--gray-medium);
        }
        
        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
            color: var(--gray-dark);
        }
        
        .close:hover {
            color: var(--text-dark);
        }
        
        input[type="file"] {
            display: none;
        }
        
        .file-label {
            background-color: var(--info);
            color: white;
            padding: 10px 20px;
            border-radius: 4px;        
            cursor: pointer;
            display: inline-block;
            transition: var(--transition);
            font-weight: 500;
            margin-bottom: 15px;
        }
        
        .file-label:hover {
            background-color: #1976D2;
        }
        
        .file-label i {
            margin-right: 8px;
        }
        
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        
        .overlay.active {
            display: block;
            visibility: visible;
            opacity: 1;
        }
        
        /* Force-hide any unexpected positioned elements */
        .user-menu [style*="position: absolute"]:not(.user-dropdown):not(.badge) {
            display: none !important;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="navbar">
                <a href="vendors.php" class="logo">
                    <i class="fas fa-leaf"></i>
                    <span>AgriMarket Solutions</span>
                </a>
                
                <button class="hamburger" id="hamburger">
                    <i class="fas fa-bars"></i>
                </button>
                
                <ul class="nav-menu" id="nav-menu">
                    <li class="nav-item">
                        <a href="products.php" class="nav-link">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="crops.php" class="nav-link">
                            <i class="fas fa-seedling"></i> Crops
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="dairy.php" class="nav-link">
                            <i class="fas fa-cow"></i> Dairy
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="fish.php" class="nav-link">
                            <i class="fas fa-fish"></i> Fish
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="forestry.php" class="nav-link">
                            <i class="fas fa-tree"></i> Forestry
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="fruit.php" class="nav-link">
                            <i class="fas fa-apple-alt"></i> Fruit
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="livestock.php" class="nav-link">
                            <i class="fas fa-drumstick-bite"></i> Livestock
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="vegetable.php" class="nav-link">
                            <i class="fas fa-carrot"></i> Vegetable
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="miscellaneous.php" class="nav-link">
                            <i class="fas fa-box"></i> Miscellaneous
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="knowledge_hub.php" class="nav-link">
                            <i class="fas fa-box"></i> Knowledge Hub
                        </a>
                    </li>
                </ul>
                
                <div class="user-menu">
                    <div class="cart-icon">
                        <a href="cart.php" class="cart-link">
                            <i class="fas fa-shopping-cart"></i>
                            <?php 
                            $cartCount = 0; // Replace with actual cart count
                            if ($cartCount > 0): 
                            ?>
                            <span class="badge"><?= $cartCount ?></span>
                            <?php endif; ?>
                        </a>
                    </div>
                    
                    <div class="notification-icon">
                        <a href="customer_notifications_page.php" class="notification-link">
                            <i class="fas fa-bell"></i>
                            <?php if ($notificationCount > 0): ?>
                            <span class="badge"><?= $notificationCount ?></span>
                            <?php endif; ?>
                        </a>
                    </div>
                    
                    <div class="user-profile">
                        <img id="avatar-img" class="avatar" src="<?= $avatarSrc ?>" alt="User Avatar">
                        <span class="user-name"><?= htmlspecialchars($userName) ?></span>
                        
                        <div class="user-dropdown">
                            <div class="user-dropdown-header">
                                <div class="user-dropdown-name"><?= htmlspecialchars($userName) ?></div>
                                <div class="user-dropdown-role">Customer</div>
                            </div>
                            
                            <a href="customer_account_settings.php" class="user-dropdown-item">
                                <i class="fas fa-user"></i> My Profile
                            </a>
                            
                            <a href="customer_order_history.php" class="user-dropdown-item">
                                <i class="fas fa-history"></i> Order History
                            </a>
                            
                            <a href="customer_preferences.php" class="user-dropdown-item">
                                <i class="fas fa-sliders-h"></i> Preferences
                            </a>
                            
                            <div class="user-dropdown-divider"></div>
                            
                            <a href="customer_complaint.php" class="user-dropdown-item">
                                <i class="fas fa-question-circle"></i> Help & Support
                            </a>
                            
                            <form action="logout.php" method="post">
                                <button type="submit" class="logout-btn">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    
    <div class="overlay" id="overlay"></div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const hamburger = document.getElementById('hamburger');
            const navMenu = document.getElementById('nav-menu');
            const overlay = document.getElementById('overlay');
    
            hamburger.addEventListener('click', () => {
                navMenu.classList.toggle('active');
                overlay.classList.toggle('active');
            });
    
            overlay.addEventListener('click', () => {
                navMenu.classList.remove('active');
                overlay.classList.remove('active');
            });
    
            // User dropdown toggle
            const userProfile = document.querySelector('.user-profile');
            const userDropdown = document.querySelector('.user-dropdown');
    
            // Ensure everything is hidden on load
            userDropdown.classList.remove('active');
            overlay.classList.remove('active');
            if (document.querySelector('.modal')) {
                document.querySelector('.modal').classList.remove('active');
            }
    
            userProfile.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                userDropdown.classList.toggle('active');
            });
    
            document.addEventListener('click', function(e) {
                if (userDropdown.classList.contains('active') && !userProfile.contains(e.target)) {
                    userDropdown.classList.remove('active');
                }
            });
    
            userDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    </script>
</body>
</html>