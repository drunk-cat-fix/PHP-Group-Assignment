<?php
session_start();
require_once 'service/Vendor_Account_Settings.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Vendor Account Settings</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <style>
    .was-validated .form-control:invalid, .form-control.is-invalid { border-color: #dc3545; }
    .was-validated .form-control:invalid:focus, .form-control.is-invalid:focus { box-shadow: none; }
    img.rounded-circle { object-fit: cover; }
  </style>
</head>
<body>
  <div class="container mt-5">
    <h2>Vendor Account Settings</h2>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php elseif (!empty($success)): ?>
      <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form id="vendorForm" class="needs-validation" novalidate method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="vendorName">Vendor Name</label>
        <input type="text" class="form-control" id="vendorName" name="vendor_name" value="<?= htmlspecialchars($vendor['vendor_name']) ?>" required>
        <div class="invalid-feedback">Please enter your vendor name.</div>
      </div>

      <div class="form-group">
        <label for="vendorDesc">Vendor Description</label>
        <textarea class="form-control" id="vendorDesc" name="vendor_desc" rows="3" required><?= htmlspecialchars($vendor['vendor_desc']) ?></textarea>
        <div class="invalid-feedback">Please enter your vendor description.</div>
      </div>

      <div class="form-group">
        <label for="shopName">Shop Name</label>
        <input type="text" class="form-control" id="shopName" name="shop_name" value="<?= htmlspecialchars($vendor['shop_name']) ?>" required>
        <div class="invalid-feedback">Please enter your shop name.</div>
      </div>

      <div class="form-group">
        <label for="shopAddress">Shop Address</label>
        <input type="text" class="form-control" id="shopAddress" name="shop_address" value="<?= htmlspecialchars($vendor['shop_address']) ?>" required>
        <div class="invalid-feedback">Please enter your shop address.</div>
      </div>

      <div class="form-group">
        <label for="shopState">Shop State</label>
        <input type="text" class="form-control" id="shopState" name="shop_state" value="<?= htmlspecialchars($vendor['shop_state']) ?>" required>
        <div class="invalid-feedback">Please enter your shop state.</div>
      </div>

      <div class="form-group">
        <label for="shopCity">Shop City</label>
        <input type="text" class="form-control" id="shopCity" name="shop_city" value="<?= htmlspecialchars($vendor['shop_city']) ?>" required>
        <div class="invalid-feedback">Please enter your shop city.</div>
      </div>

      <div class="form-group">
          <label for="vendorProfile">Profile Picture</label><br>
              <img id="profilePreview" 
                   src="<?= !empty($vendor['vendor_profile']) ? 'data:image/jpeg;base64,' . base64_encode($vendor['vendor_profile']) : '#' ?>" 
                   style="<?= !empty($vendor['vendor_profile']) ? '' : 'display:none;' ?>" 
                   width="120" height="120" class="mb-3 rounded-circle" alt="Profile Picture">
              <input type="file" class="form-control-file" id="vendorProfile" name="vendor_profile" accept="image/*">
      </div>

      <div class="form-group">
        <label for="vendorEmail">Email Address</label>
        <input type="email" class="form-control" id="vendorEmail" name="email" value="<?= htmlspecialchars($vendor['vendor_email']) ?>" required>
        <div class="invalid-feedback">Please enter a valid email address.</div>
      </div>

      <div class="form-group">
        <label for="vendorPassword">Password</label>
        <input type="password" class="form-control" id="vendorPassword" name="password" placeholder="Leave blank to keep current password">
        <div class="invalid-feedback">Please enter a password.</div>
      </div>

      <div class="form-group">
        <label for="vendorConfirmPassword">Confirm Password</label>
        <input type="password" class="form-control" id="vendorConfirmPassword" name="confirm_password" placeholder="Confirm password">
        <div class="invalid-feedback">Passwords must match and cannot be empty.</div>
      </div>

      <button type="submit" class="btn btn-primary">Update Account</button>
    </form>
  </div>

  <script>
    (function() {
      'use strict';
      var vendorForm = document.getElementById('vendorForm');
      var password = document.getElementById('vendorPassword');
      var confirmPassword = document.getElementById('vendorConfirmPassword');

      confirmPassword.addEventListener('input', function() {
        if (confirmPassword.value !== password.value) {
          confirmPassword.setCustomValidity("Passwords do not match");
        } else {
          confirmPassword.setCustomValidity("");
        }
      });

      window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (password.value && confirmPassword.value !== password.value) {
              confirmPassword.setCustomValidity("Passwords do not match");
            }
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
  </script>

  <script>
      document.getElementById('vendorProfile').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function(e) {
            const img = document.getElementById('profilePreview');
            img.src = e.target.result;
            img.style.display = 'inline-block';
          };
          reader.readAsDataURL(file);
        }
      });
    </script>
</body>
</html>
