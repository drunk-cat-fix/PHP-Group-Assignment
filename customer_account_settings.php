<?php
session_start();
require_once 'nav.php';
require_once 'service/Customer_Account_Settings.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Customer Account Settings</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <style>
    .was-validated .form-control:invalid, .form-control.is-invalid { border-color: #dc3545; }
    .was-validated .form-control:invalid:focus, .form-control.is-invalid:focus { box-shadow: none; }
    img.rounded-circle { object-fit: cover; }
  </style>
</head>
<body>
  <div class="container mt-5">
    <h2>Customer Account Settings</h2>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php elseif (!empty($success)): ?>
      <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form id="customerForm" class="needs-validation" novalidate method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="customerName">Full Name</label>
        <input type="text" class="form-control" id="customerName" name="customer_name" value="<?= htmlspecialchars($customer['customer_name']) ?>" required>
        <div class="invalid-feedback">Please enter your full name.</div>
      </div>

      <div class="form-group">
        <label for="customerAddress">Address</label>
        <input type="text" class="form-control" id="customerAddress" name="customer_address" value="<?= htmlspecialchars($customer['customer_address']) ?>" required>
        <div class="invalid-feedback">Please enter your address.</div>
      </div>

      <div class="form-group">
        <label for="customerState">State</label>
        <input type="text" class="form-control" id="customerState" name="customer_state" value="<?= htmlspecialchars($customer['customer_state']) ?>" required>
        <div class="invalid-feedback">Please enter your state.</div>
      </div>

      <div class="form-group">
        <label for="customerCity">City</label>
        <input type="text" class="form-control" id="customerCity" name="customer_city" value="<?= htmlspecialchars($customer['customer_city']) ?>" required>
        <div class="invalid-feedback">Please enter your city.</div>
      </div>

      <div class="form-group">
        <label for="customerProfile">Profile Picture</label><br>
        <img id="profilePreview"
             src="<?= !empty($customer['customer_profile']) ? 'data:image/jpeg;base64,' . base64_encode($customer['customer_profile']) : '#' ?>"
             style="<?= !empty($customer['customer_profile']) ? '' : 'display:none;' ?>"
             width="120" height="120" class="mb-3 rounded-circle" alt="Profile Picture">
        <input type="file" class="form-control-file" id="customerProfile" name="customer_profile" accept="image/*">
      </div>

      <div class="form-group">
        <label for="customerEmail">Email Address</label>
        <input type="email" class="form-control" id="customerEmail" name="email" value="<?= htmlspecialchars($customer['customer_email']) ?>" required>
        <div class="invalid-feedback">Please enter a valid email address.</div>
      </div>

      <div class="form-group">
        <label for="customerPassword">Password</label>
        <input type="password" class="form-control" id="customerPassword" name="password" placeholder="Leave blank to keep current password">
        <div class="invalid-feedback">Please enter a password.</div>
      </div>

      <div class="form-group">
        <label for="customerConfirmPassword">Confirm Password</label>
        <input type="password" class="form-control" id="customerConfirmPassword" name="confirm_password" placeholder="Confirm password">
        <div class="invalid-feedback">Passwords must match and cannot be empty.</div>
      </div>

      <button type="submit" class="btn btn-primary">Update Account</button> <br /> <br /> <br /> <br />
    </form>
  </div>

  <script>
    (function() {
      'use strict';
      var form = document.getElementById('customerForm');
      var password = document.getElementById('customerPassword');
      var confirmPassword = document.getElementById('customerConfirmPassword');

      confirmPassword.addEventListener('input', function() {
        confirmPassword.setCustomValidity(confirmPassword.value !== password.value ? "Passwords do not match" : "");
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

    document.getElementById('customerProfile').addEventListener('change', function(event) {
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
