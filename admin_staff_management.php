<?php
//    use \entities\Staff;
use entities\Staff;
//require_once 'Utilities/Connection.php';
require_once 'entities/Staff.php';
//print_r(getConnection());
if($_POST){
    require_once __DIR__ . '/service/Admin_Staff_Management.php';
    $staff = new Staff();
    $staff->setStaffPw($_POST['password']);
    $staff->setStaffName($_POST['name']);
    $staff->setStaffEmail($_POST['email']);

    if (addStaff($staff)) {
        echo "<script>alert('Staff added successfully!');</script>";
    }else{
        echo "<script>alert('Staff not added!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Staff Management</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <style>
    .was-validated .form-control:invalid, .form-control.is-invalid { border-color: #dc3545; }
    .was-validated .form-control:invalid:focus, .form-control.is-invalid:focus { box-shadow: none; }
  </style>
</head>
<body>
  <div class="container mt-5">
    <h2>Admin Staff Management</h2>
    <div class="mb-3">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStaffModal">Add Staff</button>
    </div>
    <table class="table table-bordered">
      <thead class="thead-light">
        <tr>
          <th>ID</th>
          <th>Full Name</th>
          <th>Email Address</th>
          <th>Phone Number</th>
          <th>Role</th>
          <th>Department</th>
          <th>Joining Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>John Doe</td>
          <td>johndoe@example.com</td>
          <td>1234567890</td>
          <td>Manager</td>
          <td>Operations</td>
          <td>2025-01-15</td>
          <td>
            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editStaffModal">Edit</button>
            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteStaffModal" data-staffid="1">Delete</button>
          </td>
        </tr>
        <tr>
          <td>2</td>
          <td>Jane Smith</td>
          <td>janesmith@example.com</td>
          <td>0987654321</td>
          <td>Support</td>
          <td>Customer Service</td>
          <td>2024-11-20</td>
          <td>
            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editStaffModal">Edit</button>
            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteStaffModal" data-staffid="2">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <!-- Add Staff Modal -->
  <div class="modal fade" id="addStaffModal" tabindex="-1" role="dialog" aria-labelledby="addStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form id="addStaffForm" class="needs-validation" novalidate action="admin_staff_management.php" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addStaffModalLabel">Add New Staff</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="staffFullNameAdd">Full Name</label>
              <input type="text" class="form-control" id="staffFullNameAdd" name="full_name" placeholder="Enter full name" required>
              <div class="invalid-feedback">Please enter the staff member's full name.</div>
            </div>
            <div class="form-group">
              <label for="staffEmailAdd">Email Address</label>
              <input type="email" class="form-control" id="staffEmailAdd" name="email" placeholder="Enter email address" required>
              <div class="invalid-feedback">Please enter a valid email address.</div>
            </div>
            <div class="form-group">
              <label for="staffPasswordAdd">Password</label>
              <input type="password" class="form-control" id="staffPasswordAdd" name="password" placeholder="Enter password" required>
              <div class="invalid-feedback">Please enter a password.</div>
            </div>
            <div class="form-group">
              <label for="staffConfirmPasswordAdd">Confirm Password</label>
              <input type="password" class="form-control" id="staffConfirmPasswordAdd" name="confirm_password" placeholder="Confirm password" required>
              <div class="invalid-feedback">Passwords must match and cannot be empty.</div>
            </div>
            <div class="form-group">
              <label for="staffPhoneAdd">Phone Number</label>
              <input type="tel" class="form-control" id="staffPhoneAdd" name="phone" placeholder="Enter phone number" required>
              <div class="invalid-feedback">Please enter a phone number.</div>
            </div>
            <div class="form-group">
              <label for="staffRoleAdd">Role</label>
              <select class="form-control" id="staffRoleAdd" name="role" required>
                <option value="">Choose...</option>
                <option value="manager">Manager</option>
                <option value="support">Support</option>
                <option value="maintenance">Maintenance</option>
                <option value="other">Other</option>
              </select>
              <div class="invalid-feedback">Please select a role.</div>
            </div>
            <div class="form-group">
              <label for="staffDepartmentAdd">Department</label>
              <input type="text" class="form-control" id="staffDepartmentAdd" name="department" placeholder="Enter department" required>
              <div class="invalid-feedback">Please enter a department.</div>
            </div>
            <div class="form-group">
              <label for="staffJoinDateAdd">Joining Date</label>
              <input type="date" class="form-control" id="staffJoinDateAdd" name="join_date" required>
              <div class="invalid-feedback">Please select a joining date.</div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success">Add Staff</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- Edit Staff Modal -->
  <div class="modal fade" id="editStaffModal" tabindex="-1" role="dialog" aria-labelledby="editStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form id="editStaffForm" class="needs-validation" novalidate action="#" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editStaffModalLabel">Edit Staff</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="staff_id" value="">
            <div class="form-group">
              <label for="staffFullNameEdit">Full Name</label>
              <input type="text" class="form-control" id="staffFullNameEdit" name="full_name" placeholder="Enter full name" required>
              <div class="invalid-feedback">Please enter the staff member's full name.</div>
            </div>
            <div class="form-group">
              <label for="staffEmailEdit">Email Address</label>
              <input type="email" class="form-control" id="staffEmailEdit" name="email" placeholder="Enter email address" required>
              <div class="invalid-feedback">Please enter a valid email address.</div>
            </div>
            <div class="form-group">
              <label for="staffPasswordEdit">Password</label>
              <input type="password" class="form-control" id="staffPasswordEdit" name="password" placeholder="Enter password" required>
              <div class="invalid-feedback">Please enter a password.</div>
            </div>
            <div class="form-group">
              <label for="staffConfirmPasswordEdit">Confirm Password</label>
              <input type="password" class="form-control" id="staffConfirmPasswordEdit" name="confirm_password" placeholder="Confirm password" required>
              <div class="invalid-feedback">Passwords must match and cannot be empty.</div>
            </div>
            <div class="form-group">
              <label for="staffPhoneEdit">Phone Number</label>
              <input type="tel" class="form-control" id="staffPhoneEdit" name="phone" placeholder="Enter phone number" required>
              <div class="invalid-feedback">Please enter a phone number.</div>
            </div>
            <div class="form-group">
              <label for="staffRoleEdit">Role</label>
              <select class="form-control" id="staffRoleEdit" name="role" required>
                <option value="">Choose...</option>
                <option value="manager">Manager</option>
                <option value="support">Support</option>
                <option value="maintenance">Maintenance</option>
                <option value="other">Other</option>
              </select>
              <div class="invalid-feedback">Please select a role.</div>
            </div>
            <div class="form-group">
              <label for="staffDepartmentEdit">Department</label>
              <input type="text" class="form-control" id="staffDepartmentEdit" name="department" placeholder="Enter department" required>
              <div class="invalid-feedback">Please enter a department.</div>
            </div>
            <div class="form-group">
              <label for="staffJoinDateEdit">Joining Date</label>
              <input type="date" class="form-control" id="staffJoinDateEdit" name="join_date" required>
              <div class="invalid-feedback">Please select a joining date.</div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success">Update Staff</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- Delete Staff Modal -->
  <div class="modal fade" id="deleteStaffModal" tabindex="-1" role="dialog" aria-labelledby="deleteStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form class="needs-validation" novalidate action="#" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteStaffModalLabel">Delete Staff</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="staff_id" id="deleteStaffId" value="">
            <p>Are you sure you want to delete this staff member?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">Delete Staff</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
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
    $('#deleteStaffModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var staffId = button.data('staffid');
      var modal = $(this);
      modal.find('#deleteStaffId').val(staffId);
    });
    // Add password check for Add Staff form
    (function() {
      var addPassword = document.getElementById('staffPasswordAdd');
      var addConfirm = document.getElementById('staffConfirmPasswordAdd');
      if(addConfirm){
        addConfirm.addEventListener('input', function() {
          if(addConfirm.value !== addPassword.value){
            addConfirm.setCustomValidity("Passwords do not match");
          } else {
            addConfirm.setCustomValidity("");
          }
        });
      }
    })();
    // Add password check for Edit Staff form, including warning if password is empty
    (function() {
      var editPassword = document.getElementById('staffPasswordEdit');
      var editConfirm = document.getElementById('staffConfirmPasswordEdit');
      if(editConfirm){
        editConfirm.addEventListener('input', function() {
          if(editPassword.value.trim() === ""){
            editConfirm.setCustomValidity("Please enter a password.");
          } else if(editConfirm.value !== editPassword.value){
            editConfirm.setCustomValidity("Passwords do not match");
          } else {
            editConfirm.setCustomValidity("");
          }
        });
        // Also check on form submit
        document.getElementById('editStaffForm').addEventListener('submit', function(event) {
          if(editPassword.value.trim() === ""){
            editConfirm.setCustomValidity("Please enter a password.");
          } else if(editConfirm.value !== editPassword.value){
            editConfirm.setCustomValidity("Passwords do not match");
          } else {
            editConfirm.setCustomValidity("");
          }
        });
      }
    })();
  </script>
</body>
</html>
