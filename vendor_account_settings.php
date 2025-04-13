<?php
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
  </style>
</head>
<body>
  <div class="container mt-5">
    <h2>Vendor Account Settings</h2>
    <form id="vendorForm" class="needs-validation" novalidate action="#" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="vendorName">Vendor Name</label>
        <input type="text" class="form-control" id="vendorName" name="vendor_name" placeholder="Enter vendor name" required>
        <div class="invalid-feedback">Please enter your vendor name.</div>
      </div>
      <div class="form-group">
        <label for="vendorEmail">Email Address</label>
        <input type="email" class="form-control" id="vendorEmail" name="email" placeholder="Enter your email" required>
        <div class="invalid-feedback">Please enter a valid email address.</div>
      </div>
      <div class="form-group">
        <label for="vendorPassword">Password</label>
        <input type="password" class="form-control" id="vendorPassword" name="password" placeholder="Enter password" required>
        <div class="invalid-feedback">Please enter a password.</div>
      </div>
      <div class="form-group">
        <label for="vendorConfirmPassword">Confirm Password</label>
        <input type="password" class="form-control" id="vendorConfirmPassword" name="confirm_password" placeholder="Re-enter password" required>
        <div class="invalid-feedback">Passwords must match and cannot be empty.</div>
      </div>
      <div class="form-group">
        <label for="businessName">Business Name</label>
        <input type="text" class="form-control" id="businessName" name="business_name" placeholder="Enter your business name" required>
        <div class="invalid-feedback">Please enter your business name.</div>
      </div>
      <div class="form-group">
        <label for="storeName">Store Name</label>
        <input type="text" class="form-control" id="storeName" name="store_name" placeholder="Enter your store name" required>
        <div class="invalid-feedback">Please enter your store name.</div>
      </div>
      <div class="form-group">
        <label for="vendorPhone">Phone Number</label>
        <input type="tel" class="form-control" id="vendorPhone" name="phone" placeholder="Enter your phone number" required>
        <div class="invalid-feedback">Please enter your phone number.</div>
      </div>
      <div class="form-group">
        <label for="vendorWebsite">Website URL</label>
        <input type="url" class="form-control" id="vendorWebsite" name="website" placeholder="Enter your website URL" required>
        <div class="invalid-feedback">Please enter a valid URL.</div>
      </div>
      <div class="form-group">
        <label for="vendorAddress1">Address Line 1</label>
        <input type="text" class="form-control" id="vendorAddress1" name="address1" placeholder="Street address" required>
        <div class="invalid-feedback">Please enter your address.</div>
      </div>
      <div class="form-group">
        <label for="vendorAddress2">Address Line 2</label>
        <input type="text" class="form-control" id="vendorAddress2" name="address2" placeholder="Apartment, suite, etc.">
      </div>
      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="vendorCity">City</label>
          <input type="text" class="form-control" id="vendorCity" name="city" placeholder="City" required>
          <div class="invalid-feedback">Please enter your city.</div>
        </div>
        <div class="form-group col-md-4">
          <label for="vendorState">State/Province</label>
          <input type="text" class="form-control" id="vendorState" name="state" placeholder="State/Province" required>
          <div class="invalid-feedback">Please enter your state or province.</div>
        </div>
        <div class="form-group col-md-4">
          <label for="vendorZip">ZIP/Postal Code</label>
          <input type="text" class="form-control" id="vendorZip" name="zip" placeholder="ZIP/Postal Code" required>
          <div class="invalid-feedback">Please enter your ZIP or postal code.</div>
        </div>
      </div>
      <div class="form-group">
        <label for="vendorCountry">Country</label>
        <input type="text" class="form-control" id="vendorCountry" name="country" placeholder="Country" required>
        <div class="invalid-feedback">Please enter your country.</div>
      </div>
      <div class="form-group">
        <label for="businessLicense">Business License Number</label>
        <input type="text" class="form-control" id="businessLicense" name="business_license" placeholder="Enter your business license number" required>
        <div class="invalid-feedback">Please enter your business license number.</div>
      </div>
      <div class="form-group">
        <label for="vendorLogo">Store Logo</label>
        <input type="file" class="form-control-file" id="vendorLogo" name="store_logo">
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
