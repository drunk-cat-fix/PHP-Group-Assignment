<?php
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
  </style>
</head>
<body>
  <div class="container mt-5">
    <h2>Customer Account Settings</h2>
    <form id="customerForm" class="needs-validation" novalidate action="#" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="customerName">Full Name</label>
        <input type="text" class="form-control" id="customerName" name="full_name" placeholder="Enter your full name" required>
        <div class="invalid-feedback">Please enter your full name.</div>
      </div>
      <div class="form-group">
        <label for="customerEmail">Email Address</label>
        <input type="email" class="form-control" id="customerEmail" name="email" placeholder="Enter your email" required>
        <div class="invalid-feedback">Please enter a valid email address.</div>
      </div>
      <div class="form-group">
        <label for="customerPassword">Password</label>
        <input type="password" class="form-control" id="customerPassword" name="password" placeholder="Enter password" required>
        <div class="invalid-feedback">Please enter a password.</div>
      </div>
      <div class="form-group">
        <label for="customerConfirmPassword">Confirm Password</label>
        <input type="password" class="form-control" id="customerConfirmPassword" name="confirm_password" placeholder="Re-enter password" required>
        <div class="invalid-feedback">Passwords must match and cannot be empty.</div>
      </div>
      <div class="form-group">
        <label for="customerPhone">Phone Number</label>
        <input type="tel" class="form-control" id="customerPhone" name="phone" placeholder="Enter your phone number" required>
        <div class="invalid-feedback">Please enter your phone number.</div>
      </div>
      <div class="form-group">
        <label for="customerAddress1">Address Line 1</label>
        <input type="text" class="form-control" id="customerAddress1" name="address1" placeholder="Street address, P.O. box" required>
        <div class="invalid-feedback">Please enter your address.</div>
      </div>
      <div class="form-group">
        <label for="customerAddress2">Address Line 2</label>
        <input type="text" class="form-control" id="customerAddress2" name="address2" placeholder="Apartment, suite, unit, building, floor">
      </div>
      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="customerCity">City</label>
          <input type="text" class="form-control" id="customerCity" name="city" placeholder="City" required>
          <div class="invalid-feedback">Please enter your city.</div>
        </div>
        <div class="form-group col-md-4">
          <label for="customerState">State/Province</label>
          <input type="text" class="form-control" id="customerState" name="state" placeholder="State/Province" required>
          <div class="invalid-feedback">Please enter your state or province.</div>
        </div>
        <div class="form-group col-md-4">
          <label for="customerZip">ZIP/Postal Code</label>
          <input type="text" class="form-control" id="customerZip" name="zip" placeholder="ZIP/Postal Code" required>
          <div class="invalid-feedback">Please enter your ZIP or postal code.</div>
        </div>
      </div>
      <div class="form-group">
        <label for="customerCountry">Country</label>
        <input type="text" class="form-control" id="customerCountry" name="country" placeholder="Country" required>
        <div class="invalid-feedback">Please enter your country.</div>
      </div>
      <div class="form-group">
        <label for="customerProfilePic">Profile Picture</label>
        <input type="file" class="form-control-file" id="customerProfilePic" name="profile_pic">
      </div>
      <button type="submit" class="btn btn-primary">Update Account</button>
    </form>
  </div>
  <script>
    (function() {
      'use strict';
      var customerForm = document.getElementById('customerForm');
      var password = document.getElementById('customerPassword');
      var confirmPassword = document.getElementById('customerConfirmPassword');

      confirmPassword.addEventListener('input', function() {
        if(confirmPassword.value !== password.value){
          confirmPassword.setCustomValidity("Passwords do not match");
        } else {
          confirmPassword.setCustomValidity("");
        }
      });
      
      window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            // Re-check password validity on form submit
            if(confirmPassword.value !== password.value){
              confirmPassword.setCustomValidity("Passwords do not match");
            } else {
              confirmPassword.setCustomValidity("");
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
</body>
</html>
