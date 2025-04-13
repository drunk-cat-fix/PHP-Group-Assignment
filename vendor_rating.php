<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Vendor Rating</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <style>
    .star-rating input { display: none; }
    .star-rating label { font-size: 2em; color: #ddd; cursor: pointer; }
    .star-rating input:checked ~ label { color: gold; }
    .star-rating label:hover, .star-rating label:hover ~ label { color: gold; }
    .was-validated .form-control:invalid, .form-control.is-invalid { border-color: #dc3545; }
    .was-validated .form-control:invalid:focus, .form-control.is-invalid:focus { box-shadow: none; }
    .star-rating.is-invalid .invalid-feedback { display: block; color: #dc3545; }
  </style>
</head>
<body>
  <div class="container mt-5">
    <h2>Vendor Rating</h2>
    <form class="needs-validation" novalidate action="#" method="POST">
      <div class="form-group">
        <label for="vendorId">Vendor ID</label>
        <input type="text" class="form-control" id="vendorId" name="vendor_id" placeholder="Enter vendor ID" required>
        <div class="invalid-feedback">Please enter the vendor ID.</div>
      </div>
      <div class="form-group">
        <label for="vendorName">Vendor Name</label>
        <input type="text" class="form-control" id="vendorName" name="vendor_name" placeholder="Enter vendor name" required>
        <div class="invalid-feedback">Please enter the vendor name.</div>
      </div>
      <div class="form-group">
        <label>Rating</label>
        <div class="star-rating" id="ratingGroup">
          <?php for($i = 5; $i >= 1; $i--): ?>
            <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>" required>
            <label for="star<?= $i ?>">&#9733;</label>
          <?php endfor; ?>
          <div class="invalid-feedback">Please select a rating.</div>
        </div>
      </div>
      <div class="form-group">
        <label for="vendorReview">Review</label>
        <textarea class="form-control" id="vendorReview" name="review" rows="4" placeholder="Enter your review" required></textarea>
        <div class="invalid-feedback">Please provide your review.</div>
      </div>
      <button type="submit" class="btn btn-primary">Submit Rating</button>
    </form>
  </div>
  <script>
  (function() {
    'use strict';
    window.addEventListener('load', function() {
      var forms = document.getElementsByClassName('needs-validation');
      Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          const ratingInputs = form.querySelectorAll('input[name="rating"]');
          const ratingGroup = document.getElementById('ratingGroup');
          const ratingSelected = Array.from(ratingInputs).some(input => input.checked);

          if (form.checkValidity() === false || !ratingSelected) {
            event.preventDefault();
            event.stopPropagation();
            if (!ratingSelected) {
              ratingGroup.classList.add('is-invalid');
            }
          }

          form.classList.add('was-validated');
        }, false);
      });

      const ratingInputs = document.querySelectorAll('input[name="rating"]');
      ratingInputs.forEach(function(input) {
        input.addEventListener('change', function() {
          const ratingGroup = document.getElementById('ratingGroup');
          ratingGroup.classList.remove('is-invalid');
        });
      });
    }, false);
  })();
  </script>
</body>
</html>
