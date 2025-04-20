<?php
session_start();
require_once 'service/System_Add_Vendor.php';
if (isset($_SESSION['admin_id'])) {
require_once 'admin_nav.php';
} else if (isset($_SESSION['staff_id'])) {
require_once 'staff_nav.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Vendor</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f9f9f9;
      margin: 0;
      padding: 0;
    }

    h2 {
      text-align: center;
      margin: 30px 0;
      color: #333;
    }

    form {
      background: white;
      padding: 30px;
      border-radius: 12px;
      max-width: 600px;
      margin: auto;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
    }

    label {
      margin-top: 15px;
      margin-bottom: 5px;
      font-weight: 600;
      color: #444;
    }

    input[type="text"],
    input[type="email"],
    input[type="file"],
    textarea {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 1rem;
      transition: border-color 0.3s ease;
    }

    input:focus,
    textarea:focus {
      border-color: #007bff;
      outline: none;
    }

    textarea {
      resize: vertical;
      min-height: 100px;
    }

    img#profile-preview {
      max-width: 120px;
      margin-top: 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
      display: none;
    }

    button[type="submit"] {
      margin-top: 25px;
      padding: 12px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
      background-color: #0056b3;
    }

    @media (max-width: 768px) {
      form {
        width: 90%;
        padding: 20px;
      }

      h2 {
        font-size: 1.5rem;
      }
    }
  </style>
</head>
<body>

<h2>Add Vendor</h2>

<form id="addVendorForm" action="service/System_Add_Vendor.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
  <label for="vendor_name">Vendor Name</label>
  <input type="text" id="vendor_name" name="vendor_name" required>

  <label for="vendor_email">Email</label>
  <input type="email" id="vendor_email" name="vendor_email" required>

  <label for="vendor_description">Description</label>
  <textarea id="vendor_description" name="vendor_description" required></textarea>

  <label for="shop_name">Shop Name</label>
  <input type="text" id="shop_name" name="shop_name" required>

  <label for="shop_address">Shop Address</label>
  <input type="text" id="shop_address" name="shop_address" required>

  <label for="shop_city">Shop City</label>
  <input type="text" id="shop_city" name="shop_city" required>

  <label for="shop_state">Shop State</label>
  <input type="text" id="shop_state" name="shop_state" required>

  <label for="profile">Upload Profile Picture</label>
  <input type="file" id="profile" name="profile" accept=".jpeg, .png, .jpg, .bmp" onchange="previewProfile()">
  <img id="profile-preview" src="" alt="Profile Preview">

  <button type="submit">Add Vendor</button>
</form>

<script>
  function previewProfile() {
    const file = document.getElementById("profile").files[0];
    const reader = new FileReader();

    reader.onload = function (e) {
      const img = document.getElementById("profile-preview");
      img.src = e.target.result;
      img.style.display = "block";
    };

    if (file) {
      reader.readAsDataURL(file);
    }
  }

  function validateForm() {
    const vendorName = document.getElementById("vendor_name").value;
    const description = document.getElementById("vendor_description").value;
    const shopName = document.getElementById("shop_name").value;
    const shopAddress = document.getElementById("shop_address").value;
    const shopCity = document.getElementById("shop_city").value;
    const shopState = document.getElementById("shop_state").value;
    const email = document.getElementById("vendor_email").value;
    const profile = document.getElementById("profile").files[0];

    if (!vendorName || !description || !shopName || !shopAddress || !shopCity || !shopState || !email) {
      alert("❗ Please fill in all fields.");
      return false;
    }

    if (!profile) {
      alert("📸 Please upload a profile picture.");
      return false;
    }

    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!emailRegex.test(email)) {
      alert("❗ Please enter a valid email address.");
      return false;
    }

    alert("✅ Vendor added successfully!");
    return true;
  }
</script>

</body>
</html>

