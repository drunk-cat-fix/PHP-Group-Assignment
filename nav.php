<?php
/**
 * This is a modular for the navigation for each page
 *  just require_once this file.
 */
require_once "Utilities/Connection.php";
require_once 'service/Customer_Notification.php';
$notificationCount = count($notifications);

$sql = "SELECT customer_name, customer_profile FROM customer WHERE customer_id = ?";
$stmt = getConnection()->prepare($sql);
$stmt->bindParam(1, $_SESSION['customer_id']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$userName = $row["customer_name"];
$avatarData = $row["customer_profile"];
$avatarData=stripslashes($avatarData);
function getImageMimeType($binaryData) {
    if (empty($binaryData)) return 'image/jpeg';

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->buffer($binaryData);

    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    return in_array($mimeType, $allowed) ? $mimeType : 'image/jpeg';
}

$mimeType = getImageMimeType($avatarData);
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>Index Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #4CAF50;
            overflow: hidden;
            display: flex;
            justify-content: center;
            padding: 10px 0;
        }
        .nav-item {
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            font-size: 18px;
            transition: background 0.3s, transform 0.2s;
        }
        .nav-item:hover {
            background-color: #45a049;
            transform: scale(1.1);
        }
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 150px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 5px;
            overflow: hidden;
            padding: 10px 0;
        }
        .dropdown-content a {
            color: black;
            padding: 10px 20px;
            display: block;
            text-decoration: none;
            transition: background 0.3s;
        }
        .dropdown-content a:hover {
            background-color: #ddd;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
        .avatar-container {
            text-align: center;
            margin-top: 50px;
            /*float: right;*/
        }
        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            cursor: pointer;
            border: 2px solid #ddd;
            transition: transform 0.3s ease;
        }
        .avatar:hover {
            transform: scale(1.1);
        }
        .welcome {
            font-size: 24px;
            margin: 20px 0;
        }
        input[type="file"] {
            display: none;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            position: relative;
        }
        .modal img {
            width: 300px;
            height: 300px;
            border-radius: 10px;
            object-fit: cover;
        }
        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
        }
        .logout-btn {
            background-color: #ff4b5c;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }
        .logout-btn:hover {
            background-color: #e63946;
            transform: scale(1.05);
        }
        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            color: white;
            padding: 10px 20px;
        }
        .nav-links {
            display: flex;
            gap: 20px;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 5px 10px;
        }
        .nav-links a:hover {
            background-color: #555;
            border-radius: 4px;
        }
        .notification-icon {
            position: relative;
            font-size: 20px;
            cursor: pointer;
            margin-left: 15px;
        }
        .badge {
            position: absolute;
            top: -10px;
            right: -10px;
            padding: 3px 6px;
            border-radius: 50%;
            background: red;
            color: white;
            font-size: 12px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div class="dropdown">
        <a href="crops.php" class="nav-item">Crops</a>
    </div>
    <div class="dropdown">
        <a href="dairy.php" class="nav-item">Dairy</a>
    </div>
    <div class="dropdown">
        <a href="fish.php" class="nav-item">Fish</a>
    </div>
    <div class="dropdown">
        <a href="forestry.php" class="nav-item">Forestry</a>
    </div>
    <div class="dropdown">
        <a href="fruit.php" class="nav-item">Fruit</a>
    </div>
    <div class="dropdown">
        <a href="livestock.php" class="nav-item">Livestock</a>
    </div>
    <div class="dropdown">
        <a href="miscellaneous.php" class="nav-item">Miscellaneous</a>
    </div>
    <div class="dropdown">
        <a href="vegetable.php" class="nav-item">Vegetable</a>
    </div>
    <div class="dropdown">
        <a href="cart.php" class="nav-item">Cart</a>
    </div>
    <div class="dropdown">
        <a href="customer_order_history.php" class="nav-item">Order History</a>
    </div>

    <div class="dropdown">
        <a href="customer_preferences.php" class="nav-item">Preferences</a>
    </div>

    <a href="customer_notifications_page.php" class="notification-icon">
        🔔
        <?php if ($notificationCount > 0): ?>
            <span class="badge"><?= $notificationCount ?></span>
        <?php endif; ?>
    </a>

</div>


<script>
    document.getElementById("avatar-img").addEventListener("click", function () {
        const modal = document.getElementById("previewModal");
        document.getElementById("preview-img").src = this.src;
        modal.style.display = "flex";
    });

    document.querySelector(".close").addEventListener("click", function () {
        document.getElementById("previewModal").style.display = "none";
    });

    document.getElementById("upload-avatar").addEventListener("change", function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById("preview-img").src = e.target.result;
            };
            reader.readAsDataURL(file);

            document.getElementById("previewModal").style.display = "flex";
        }
    });

    document.getElementById("upload-button").addEventListener("click", function () {
        const fileInput = document.getElementById("upload-avatar");
        const file = fileInput.files[0];

        if (!file) {
            alert("Please Select Image Firstly ！");
            return;
        }

        const formData = new FormData();
        formData.append("avatar", file);
        formData.append("customer_id", <?= $_SESSION['customer_id'] ?>);

        fetch("Utilities/Upload.php", {
            method: "POST",
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            })
            .catch(error => console.error("Upload failed:", error));
    });
</script>

</body>
</html>
