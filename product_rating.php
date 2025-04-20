<?php
session_start();
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}
require_once 'service/Product_Rating.php';
require_once 'nav.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate Product | AgriMarket Solutions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #4CAF50;
            --secondary-color: #45a049;
            --accent-color: #ff6b6b;
            --light-gray: #f5f5f5;
            --medium-gray: #ddd;
            --dark-gray: #666;
            --text-color: #333;
            --white: #fff;
            --shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
            --blue: #2196F3;
            --orange: #FF9800;
            --purple: #3F51B5;
            --yellow: #FFD700;
            --red: #dc3545;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--light-gray);
            color: var(--text-color);
            line-height: 1.6;
            padding-top: 0;
            margin-top: 0;
        }
        
        /* Ensure header has proper z-index */
        .header {
            position: relative !important;
            z-index: 9999 !important;
        }

        .navbar {
            position: relative !important;
            z-index: 9999 !important;
        }
        
        .page-header {
            background-color: var(--white);
            padding: 20px;
            box-shadow: var(--shadow);
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
            margin-top: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        h1 {
            color: var(--primary-color);
            text-align: center;
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            color: var(--dark-gray);
            margin-bottom: 20px;
            font-size: 1rem;
        }
        
        .rating-card {
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: var(--transition);
            margin-bottom: 30px;
        }
        
        .rating-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }
        
        .product-info {
            display: flex;
            align-items: center;
            padding: 20px;
            background-color: rgba(76, 175, 80, 0.05);
            border-bottom: 1px solid var(--medium-gray);
        }
        
        .product-image {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 20px;
            border: 1px solid var(--medium-gray);
        }
        
        .product-details {
            flex: 1;
        }
        
        .product-name {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: 5px;
            font-weight: 600;
        }
        
        .rating-form {
            padding: 25px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: var(--dark-gray);
            font-size: 1.1rem;
        }
        
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            margin-bottom: 5px;
        }
        
        .star-rating input {
            display: none;
        }
        
        .star-rating label {
            font-size: 2.5rem;
            color: var(--medium-gray);
            cursor: pointer;
            transition: var(--transition);
            margin-right: 5px;
        }
        
        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: var(--yellow);
        }
        
        .star-rating-hint {
            color: var(--dark-gray);
            font-size: 0.9rem;
            margin-top: 5px;
        }
        
        .review-textarea {
            width: 100%;
            padding: 15px;
            border: 1px solid var(--medium-gray);
            border-radius: 6px;
            font-size: 1rem;
            min-height: 150px;
            transition: var(--transition);
            resize: vertical;
        }
        
        .review-textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
        }
        
        .submit-btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: var(--white);
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
        }
        
        .submit-btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .cancel-btn {
            display: inline-block;
            background-color: var(--light-gray);
            color: var(--dark-gray);
            padding: 12px 24px;
            border: 1px solid var(--medium-gray);
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
            margin-right: 10px;
            text-decoration: none;
        }
        
        .cancel-btn:hover {
            background-color: var(--medium-gray);
        }
        
        .error-alert {
            padding: 15px;
            background-color: #FFEBEE;
            border-left: 4px solid var(--red);
            margin-bottom: 20px;
            color: var(--red);
            border-radius: 4px;
        }
        
        .is-invalid {
            border-color: var(--red) !important;
        }
        
        .invalid-feedback {
            color: var(--red);
            font-size: 0.875rem;
            margin-top: 5px;
            display: none;
        }
        
        .is-invalid + .invalid-feedback,
        .is-invalid > .invalid-feedback {
            display: block;
        }
        
        .button-group {
            display: flex;
            margin-top: 20px;
        }
        
        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 15px;
            }
            
            .product-info {
                flex-direction: column;
                text-align: center;
            }
            
            .product-image {
                margin-right: 0;
                margin-bottom: 15px;
            }
            
            .star-rating label {
                font-size: 2rem;
            }
            
            .button-group {
                flex-direction: column-reverse;
                gap: 10px;
            }
            
            .cancel-btn, .submit-btn {
                width: 100%;
                margin-right: 0;
            }
        }
        :root {
            --primary-color: #4CAF50;
            --secondary-color: #45a049;
            --accent-color: #ff6b6b;
            --light-gray: #f5f5f5;
            --medium-gray: #ddd;
            --dark-gray: #666;
            --text-color: #333;
            --white: #fff;
            --shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--light-gray);
            color: var(--text-color);
            line-height: 1.6;
            padding-top: 0;
            margin-top: 0;
        }
        
        /* Ensure header has proper z-index */
        .header {
            position: relative !important;
            z-index: 9999 !important;
        }

        .navbar {
            position: relative !important;
            z-index: 9999 !important;
        }
        
        .page-header {
            background-color: var(--white);
            padding: 20px;
            box-shadow: var(--shadow);
            margin-bottom: 20px;
            position: relative;
            z-index: 1; /* Ensure this is below the navigation */
            margin-top: 20px; /* Add spacing below the navbar */
            z-index: 1;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 8px;
        }

        .container:first-of-type {
            position: relative;
            z-index: 1;
        }
        
        h1 {
            color: var(--primary-color);
            text-align: center;
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            color: var(--dark-gray);
            margin-bottom: 20px;
            font-size: 1rem;
        }
        
        .summary-card {
            background-color: var(--light-gray);
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            transition: var(--transition);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }
        
        .summary-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .summary-title {
            color: var(--dark-gray);
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        
        .summary-value {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--primary-color);
        }
        
        .summary-icon {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 10px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: var(--shadow);
            border-radius: 8px;
            overflow: hidden;
        }
        
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid var(--medium-gray);
        }
        
        th {
            background-color: var(--primary-color);
            color: var(--white);
            font-weight: 600;
            font-size: 0.95rem;
        }
        
        tbody tr {
            transition: var(--transition);
        }
        
        tbody tr:nth-child(even) {
            background-color: rgba(76, 175, 80, 0.05);
        }
        
        tbody tr:hover {
            background-color: rgba(76, 175, 80, 0.1);
        }
        
        .product-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            transition: var(--transition);
        }
        
        .product-link:hover {
            color: var(--secondary-color);
        }
        
        .product-link i {
            margin-right: 5px;
        }
        
        .product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid var(--medium-gray);
        }
        
        .price {
            font-weight: bold;
            color: var(--accent-color);
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 0;
        }
        
        .empty-state-icon {
            font-size: 4rem;
            color: var(--medium-gray);
            margin-bottom: 20px;
        }
        
        .empty-state-message {
            font-size: 1.2rem;
            color: var(--dark-gray);
            margin-bottom: 20px;
        }
        
        .shop-now-btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: var(--white);
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            transition: var(--transition);
        }
        
        .shop-now-btn:hover {
            background-color: var(--secondary-color);
        }
        
        @media (max-width: 992px) {
            .container {
                width: 90%;
            }
        }
        
        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 15px;
            }
            
            table {
                display: block;
                overflow-x: auto;
            }
            
            th, td {
                padding: 12px 10px;
            }
            
            .product-image {
                width: 80px;
                height: 80px;
            }
        }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="container" style="box-shadow: none; margin-bottom: 0;">
            <h1>Rate Product</h1>
            <p class="subtitle">Share your experience with this product</p>
        </div>
    </div>

    <div class="container">
        <div class="rating-card">
            <div class="product-info">
                <?php if (!empty($product['product_profile'])): ?>
                    <img src="data:image/jpeg;base64,<?= base64_encode($product['product_profile']) ?>" class="product-image" alt="<?= htmlspecialchars($product['product_name']) ?>">
                <?php else: ?>
                    <div class="product-image" style="display: flex; align-items: center; justify-content: center; background-color: var(--light-gray);">
                        <i class="fas fa-image" style="font-size: 3rem; color: var(--medium-gray);"></i>
                    </div>
                <?php endif; ?>
                
                <div class="product-details">
                    <div class="product-name"><?= htmlspecialchars($product['product_name']) ?></div>
                    <div class="product-category">
                        <i class="fas fa-tag"></i> <?= htmlspecialchars($product['product_category'] ?? 'General') ?>
                    </div>
                </div>
            </div>
            
            <?php if (!empty($error)): ?>
                <div class="error-alert">
                    <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <form class="rating-form needs-validation" novalidate method="POST">
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-star"></i> Your Rating</label>
                    <div class="star-rating" id="ratingGroup">
                        <?php for ($i = 5; $i >= 1; $i--): ?>
                            <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>" required>
                            <label for="star<?= $i ?>">★</label>
                        <?php endfor; ?>
                        <div class="invalid-feedback">Please select a rating.</div>
                    </div>
                    <div class="star-rating-hint">Click on a star to rate this product</div>
                </div>
                
                <div class="form-group">
                    <label for="productReview" class="form-label"><i class="fas fa-comment"></i> Your Review</label>
                    <textarea class="review-textarea" id="productReview" name="review" placeholder="Share your experience with this product..." required></textarea>
                    <div class="invalid-feedback">Please provide your review.</div>
                </div>
                
                <div class="button-group">
                    <button type="button" onclick="window.history.back()" class="cancel-btn">
                        <i class="fas fa-arrow-left"></i> Cancel
                    </button>
                    <button type="submit" class="submit-btn">
                        <i class="fas fa-paper-plane"></i> Submit Review
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    const ratingInputs = form.querySelectorAll('input[name="rating"]');
                    const ratingGroup = document.getElementById('ratingGroup');
                    const ratingSelected = Array.from(ratingInputs).some(input => input.checked);
                    const reviewTextarea = document.getElementById('productReview');
                    
                    if (form.checkValidity() === false || !ratingSelected) {
                        event.preventDefault();
                        event.stopPropagation();
                        
                        if (!ratingSelected) {
                            ratingGroup.classList.add('is-invalid');
                        }
                        
                        if (!reviewTextarea.validity.valid) {
                            reviewTextarea.classList.add('is-invalid');
                        }
                    }
                    
                    form.classList.add('was-validated');
                }, false);
            });
            
            const ratingInputs = document.querySelectorAll('input[name="rating"]');
            ratingInputs.forEach(function(input) {
                input.addEventListener('change', function() {
                    const ratingGroup = document.getElementById('ratingGroup');
                    ratingGroup.classList.remove('is-invalid');
                });
            });
            
            const reviewTextarea = document.getElementById('productReview');
            reviewTextarea.addEventListener('input', function() {
                if (this.validity.valid) {
                    this.classList.remove('is-invalid');
                }
            });
        }, false);
    })();
    </script>
</body>
</html>