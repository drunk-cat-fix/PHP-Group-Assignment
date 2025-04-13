<?php
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
    <form class="needs-validation" novalidate action="#" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="complaintAgainst">Complaint Against (Vendor, Product, Service, etc.)</label>
        <input type="text" class="form-control" id="complaintAgainst" name="complaint_against" placeholder="Specify who or what you are complaining about" required>
        <div class="invalid-feedback">Please specify who or what you are complaining about.</div>
      </div>
      <div class="form-group">
        <label for="complaintSubject">Complaint Subject</label>
        <input type="text" class="form-control" id="complaintSubject" name="complaint_subject" placeholder="Enter a subject for your complaint" required>
        <div class="invalid-feedback">Please enter a complaint subject.</div>
      </div>
      <div class="form-group">
        <label for="orderId">Order ID (if applicable)</label>
        <input type="text" class="form-control" id="orderId" name="order_id" placeholder="Enter your order ID">
      </div>
      <div class="form-group">
        <label for="complaintDetails">Complaint Details</label>
        <textarea class="form-control" id="complaintDetails" name="complaint_details" rows="4" placeholder="Describe your complaint in detail" required></textarea>
        <div class="invalid-feedback">Please describe your complaint.</div>
      </div>
      <div class="form-group">
        <label for="complaintAttachment">Supporting File (optional)</label>
        <input type="file" class="form-control-file" id="complaintAttachment" name="attachment">
      </div>
      <button type="submit" class="btn btn-danger">Submit Complaint</button>
    </form>
  </div>
  <script>
    (function() {
      'use strict';
      window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if(form.checkValidity() === false) {
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
