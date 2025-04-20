<?php
session_start();
require_once 'Utilities/Connection.php';
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vendor_id = intval($_GET['id'] ?? 0);
    $customer_id = $_SESSION['customer_id'] ?? null;
    $rating = $_POST['rating'] ?? null;
    $review = trim($_POST['review'] ?? '');

    if (!$vendor_id || !$customer_id || !$rating || $review === '') {
        $error = "Please provide both a rating and a review.";
    } else {
        $conn = getConnection();
        $stmt = $conn->prepare("INSERT INTO vendor_review (vendor_id, customer_id, vendor_review, vendor_rating) VALUES (?, ?, ?, ?)");
        $stmt->execute([$vendor_id, $customer_id, $review, $rating]);
        header("Location: shop.php?id=" . $vendor_id);
        exit();
    }
}

// Check if vendor ID is provided
if (!isset($_GET['id'])) {
    die("Vendor ID not specified.");
}

$vendor_id = intval($_GET['id']);
$customer_id = $_SESSION['customer_id'] ?? null;

// Check if customer is logged in
if (!$customer_id) {
    die("Customer not logged in.");
}

$conn = getConnection();

// Fetch vendor details
$stmt = $conn->prepare("SELECT vendor_name, shop_name FROM vendor WHERE vendor_id = ?");
$stmt->execute([$vendor_id]);
$vendor = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$vendor) {
    die("Vendor not found.");
}

// Only include nav.php and HTML after all redirect logic
require_once 'nav_logic.php';
require_once 'nav.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Rating | FarmFresh Market</title>
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
            --shadow: 0 4px 8px rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
            --yellow: #FFD700;
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
        }
        
        .page-header {
            background-color: var(--white);
            padding: 20px;
            box-shadow: var(--shadow);
            margin-bottom: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
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
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .vendor-info {
            margin-bottom: 25px;
            border-bottom: 1px solid var(--medium-gray);
            padding-bottom: 15px;
        }
        
        .vendor-info p {
            margin-bottom: 8px;
            font-size: 1.1rem;
        }
        
        .vendor-info strong {
            color: var(--primary-color);
            font-weight: 600;
            margin-right: 5px;
        }
        
        .rating-form .form-group {
            margin-bottom: 25px;
        }
        
        .rating-form label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-color);
            font-size: 1.1rem;
        }
        
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            margin-bottom: 5px;
        }

        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: var(--yellow);
        }
        
        .star-rating input {
            display: none;
        }
        
        .star-rating label {
            font-size: 2.5em;
            color: var(--medium-gray);
            cursor: pointer;
            transition: var(--transition);
            margin-right: 5px;
        }
        
        .review-textarea {
            width: 100%;
            padding: 15px;
            border: 1px solid var(--medium-gray);
            border-radius: 8px;
            font-size: 1rem;
            transition: var(--transition);
            resize: vertical;
            min-height: 120px;
        }
        
        .review-textarea:focus {
            outline: none;
            border-color: var(--primary-color);
        }
        
        .submit-btn {
            background-color: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 12px 25px;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: inline-block;
        }
        
        .submit-btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .error-message {
            color: var(--accent-color);
            font-size: 0.9rem;
            margin-top: 5px;
            display: none;
        }
        
        .star-rating.is-invalid + .error-message {
            display: block;
        }
        
        .review-textarea.is-invalid {
            border-color: var(--accent-color);
        }
        
        .review-textarea.is-invalid + .error-message {
            display: block;
        }
        
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .alert-danger {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }
        
        .alert-success {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }
        
        @media (max-width: 768px) {
            .rating-card {
                padding: 20px;
            }
            
            .star-rating label {
                font-size: 2em;
            }
        }
        
        @media (max-width: 480px) {
            .rating-card {
                padding: 15px;
            }
            
            .vendor-info p {
                font-size: 1rem;
            }
            
            .star-rating label {
                font-size: 1.8em;
            }
            
            .submit-btn {
                width: 100%;
                padding: 10px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="container">
            <h1>Vendor Rating</h1>
            <p class="subtitle">Share your experience with this vendor</p>
        </div>
    </div>

    <div class="container">
        <div class="rating-card">
            <div class="vendor-info">
                <p><strong>Vendor:</strong> <?= htmlspecialchars($vendor['vendor_name']) ?></p>
                <p><strong>Shop:</strong> <?= htmlspecialchars($vendor['shop_name']) ?></p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form class="rating-form" id="ratingForm" method="POST">
                <div class="form-group">
                    <label for="ratingGroup">How would you rate this vendor?</label>
                    <div class="star-rating" id="ratingGroup">
                        <?php for ($i = 5; $i >= 1; $i--): ?>
                            <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>" required>
                            <label for="star<?= $i ?>">★</label>
                        <?php endfor; ?>
                    </div>
                    <div class="error-message" id="ratingError">
                        <i class="fas fa-exclamation-circle"></i> Please select a rating
                    </div>
                </div>

                <div class="form-group">
                    <label for="vendorReview">Write your review</label>
                    <textarea class="review-textarea" id="vendorReview" name="review" 
                        placeholder="Share details of your experience with this vendor..." required></textarea>
                    <div class="error-message" id="reviewError">
                        <i class="fas fa-exclamation-circle"></i> Please provide your review
                    </div>
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i> Submit Rating
                </button>
            </form>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ratingForm = document.getElementById('ratingForm');
            const ratingGroup = document.getElementById('ratingGroup');
            const ratingInputs = document.querySelectorAll('input[name="rating"]');
            const reviewTextarea = document.getElementById('vendorReview');
            
            // Remove validation errors when rating is selected
            ratingInputs.forEach(function(input) {
                input.addEventListener('change', function() {
                    ratingGroup.classList.remove('is-invalid');
                    document.getElementById('ratingError').style.display = 'none';
                });
            });
            
            // Remove validation errors when review is typed
            reviewTextarea.addEventListener('input', function() {
                this.classList.remove('is-invalid');
                document.getElementById('reviewError').style.display = 'none';
            });
            
            // Form validation
            ratingForm.addEventListener('submit', function(event) {
                let isValid = true;
                
                // Validate rating
                const ratingSelected = Array.from(ratingInputs).some(input => input.checked);
                if (!ratingSelected) {
                    ratingGroup.classList.add('is-invalid');
                    document.getElementById('ratingError').style.display = 'block';
                    isValid = false;
                }
                
                // Validate review
                if (reviewTextarea.value.trim() === '') {
                    reviewTextarea.classList.add('is-invalid');
                    document.getElementById('reviewError').style.display = 'block';
                    isValid = false;
                }
                
                if (!isValid) {
                    event.preventDefault();
                    event.stopPropagation();
                }
            });
        });
    </script>
</body>
</html>