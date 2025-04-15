<?php
require_once __DIR__ . '/../Utilities/Connection.php';
$_SESSION['customer_id'] = 1;
$customer_id = $_SESSION['customer_id'] ?? null;

if (!$customer_id) {
  die("Unauthorized access.");
}

$error = '';
$success = '';

$conn = getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $customer_name = $_POST['customer_name'];
  $customer_email = $_POST['email'];
  $customer_address = $_POST['customer_address'];
  $customer_state = $_POST['customer_state'];
  $customer_city = $_POST['customer_city'];

  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  // File upload (optional)
  $customer_profile = null;
  if (!empty($_FILES['customer_profile']['tmp_name'])) {
    $customer_profile = file_get_contents($_FILES['customer_profile']['tmp_name']);
  }

  if (!empty($password)) {
    if ($password !== $confirm_password) {
      $error = "Passwords do not match.";
    } else {
      $password_hash = password_hash($password, PASSWORD_DEFAULT);
      $query = "UPDATE customer SET customer_name = :customer_name, customer_email = :customer_email, customer_address = :customer_address, customer_state = :customer_state, customer_city = :customer_city, customer_pw = :customer_pw";
      if ($customer_profile) {
        $query .= ", customer_profile = :customer_profile";
      }
      $query .= " WHERE customer_id = :customer_id";

      $stmt = $conn->prepare($query);
      $params = [
        ':customer_name' => $customer_name,
        ':customer_email' => $customer_email,
        ':customer_address' => $customer_address,
        ':customer_state' => $customer_state,
        ':customer_city' => $customer_city,
        ':customer_pw' => $password_hash,
        ':customer_id' => $customer_id
      ];
      if ($customer_profile) {
        $params[':customer_profile'] = $customer_profile;
      }

      if ($stmt->execute($params)) {
        $success = "Account updated successfully.";
      } else {
        $error = "Error updating account: " . $stmt->errorInfo()[2];
      }
    }
  } else {
    $query = "UPDATE customer SET customer_name = :customer_name, customer_email = :customer_email, customer_address = :customer_address, customer_state = :customer_state, customer_city = :customer_city";
    if ($customer_profile) {
      $query .= ", customer_profile = :customer_profile";
    }
    $query .= " WHERE customer_id = :customer_id";

    $stmt = $conn->prepare($query);
    $params = [
      ':customer_name' => $customer_name,
      ':customer_email' => $customer_email,
      ':customer_address' => $customer_address,
      ':customer_state' => $customer_state,
      ':customer_city' => $customer_city,
      ':customer_id' => $customer_id
    ];
    if ($customer_profile) {
      $params[':customer_profile'] = $customer_profile;
    }

    if ($stmt->execute($params)) {
      $success = "Account updated successfully.";
    } else {
      $error = "Error updating account: " . $stmt->errorInfo()[2];
    }
  }
}

// Fetch customer info
$stmt = $conn->prepare("SELECT customer_name, customer_email, customer_address, customer_state, customer_city, customer_profile FROM customer WHERE customer_id = :customer_id");
$stmt->execute([':customer_id' => $customer_id]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);
?>
