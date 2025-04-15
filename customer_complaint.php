<?php
require_once 'service/Customer_Complaint.php';
session_start();
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

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php elseif ($success): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

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
      <input type="file" class="form-control-file" id="complaintAttachment" name="attachment" accept="image/*">
      <div id="imagePreview" class= "mt-3">
        <img id="previewImg" src="#" alt="Preview" style="display: none; max-width: 200px; max-height: 200px;" class="img-thumbnail">
      </div>
    </div>

    <button type="submit" class="btn btn-danger">Submit Complaint</button>
  </form>
</div>

<script>
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
