<?php
session_start();
require_once 'service/Customer_Complaint.php';
require_once 'nav.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Customer Complaint</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <style>
    .was-validated .form-control:invalid, .form-control.is-invalid { border-color: #dc3545; }
    .was-validated .form-control:invalid:focus, .form-control.is-invalid:focus { box-shadow: none; }
  </style>
</head>
<body>
<div class="container mt-5">
  <h2>Customer Complaint</h2>


  <form class="needs-validation" novalidate action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <label for="complaintAgainst">Complaint Against</label>
      <select class="form-control" id="complaintAgainst" name="complaint_against" required>
        <option value="">Please select a category</option>
        <option value="Vendor">Vendor</option>
        <option value="Product">Product</option>
        <option value="Service">Service</option>
        <option value="Order">Order</option>
        <option value="Others">Others</option>
      </select>
      <div class="invalid-feedback">Please select a complaint category.</div>
    </div>

    <div class="form-group">
      <label for="complaintSubject">Complaint Subject</label>
      <input type="text" class="form-control" id="complaintSubject" name="complaint_subject" required>
      <div class="invalid-feedback">Please enter a subject.</div>
    </div>

    <div class="form-group">
      <label for="orderId">Order ID (optional)</label>
      <input type="text" class="form-control" id="orderId" name="order_id">
    </div>

    <div class="form-group">
      <label for="complaintDetails">Complaint Details</label>
      <textarea class="form-control" id="complaintDetails" name="complaint_details" rows="4" required></textarea>
      <div class="invalid-feedback">Please provide complaint details.</div>
    </div>

    <div class="form-group">
      <label for="complaintAttachment">Supporting File (optional)</label>
      <div class="custom-file mb-3">
          <input type="file" class="custom-file-input" id="complaintAttachment" name="attachment" accept="image/*">
          <label class="custom-file-label" for="complaintAttachment">Choose file</label>
        </div>
    </div>

    <button type="submit" class="btn btn-danger">Submit Complaint</button>
  </form>
</div>

<script>
document.querySelector('.custom-file-input').addEventListener('change', function (e) {
    var fileName = e.target.files[0]?.name || 'Choose file';
    e.target.nextElementSibling.innerText = fileName;
  });
  (function () {
    'use strict';
    window.addEventListener('load', function () {
      const forms = document.getElementsByClassName('needs-validation');
      Array.prototype.filter.call(forms, function (form) {
        form.addEventListener('submit', function (event) {
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
  document.getElementById('complaintAttachment').addEventListener('change', function (event) {
    const file = event.target.files[0];
    const previewImg = document.getElementById('previewImg');

    if (file && file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = function (e) {
        previewImg.src = e.target.result;
        previewImg.style.display = 'block';
      };
      reader.readAsDataURL(file);
    } else {
      previewImg.style.display = 'none';
      previewImg.src = '#';
    }
  });
</script>
</body>
</html>
