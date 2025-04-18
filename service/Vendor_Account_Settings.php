<?php
require_once __DIR__ . '/../Utilities/Connection.php';
$vendor_id = $_SESSION['vendor_id'] ?? null;

if (!$vendor_id) {
  die("Unauthorized access.");
}

$error = '';
$success = '';

$conn = getConnection();

if (isset($_GET['delete']) && $_GET['delete'] == 1) {
  $deleteStmt = $conn->prepare("DELETE FROM vendor WHERE vendor_id = :vendor_id");
  if ($deleteStmt->execute([':vendor_id' => $vendor_id])) {
    session_destroy();
    echo "<script>alert('Your account has been deleted.'); window.location.href='login.php';</script>";
    exit;
  } else {
    $error = "Failed to delete account: " . $deleteStmt->errorInfo()[2];
  }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $vendor_name = $_POST['vendor_name'];
  $vendor_email = $_POST['email'];
  $vendor_desc = $_POST['vendor_desc'];
  $shop_name = $_POST['shop_name'];
  $shop_address = $_POST['shop_address'];
  $shop_state = $_POST['shop_state'];
  $shop_city = $_POST['shop_city'];

  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  // File upload (optional)
  $vendor_profile = null;
  if (!empty($_FILES['vendor_profile']['tmp_name'])) {
    $vendor_profile = file_get_contents($_FILES['vendor_profile']['tmp_name']);
  }

  if (!empty($password)) {
    if ($password !== $confirm_password) {
      $error = "Passwords do not match.";
    } else {
      $password_hash = password_hash($password, PASSWORD_DEFAULT);
      $query = "UPDATE vendor SET vendor_name = :vendor_name, vendor_email = :vendor_email, vendor_desc = :vendor_desc, shop_name = :shop_name, shop_address = :shop_address, shop_state = :shop_state, shop_city = :shop_city, vendor_pw = :vendor_pw";
      if ($vendor_profile) {
        $query .= ", vendor_profile = :vendor_profile";
      }
      $query .= " WHERE vendor_id = :vendor_id";

      $stmt = $conn->prepare($query);
      $params = [
        ':vendor_name' => $vendor_name,
        ':vendor_email' => $vendor_email,
        ':vendor_desc' => $vendor_desc,
        ':shop_name' => $shop_name,
        ':shop_address' => $shop_address,
        ':shop_state' => $shop_state,
        ':shop_city' => $shop_city,
        ':vendor_pw' => $password_hash,
        ':vendor_id' => $vendor_id
      ];
      if ($vendor_profile) {
        $params[':vendor_profile'] = $vendor_profile;
      }
      if ($stmt->execute($params)) {
        $success = "Account updated successfully.";
      } else {
        $error = "Error updating account: " . $stmt->errorInfo()[2];
      }
    }
  } else {
    $query = "UPDATE vendor SET vendor_name = :vendor_name, vendor_email = :vendor_email, vendor_desc = :vendor_desc, shop_name = :shop_name, shop_address = :shop_address, shop_state = :shop_state, shop_city = :shop_city";
    if ($vendor_profile) {
      $query .= ", vendor_profile = :vendor_profile";
    }
    $query .= " WHERE vendor_id = :vendor_id";

    $stmt = $conn->prepare($query);
    $params = [
      ':vendor_name' => $vendor_name,
      ':vendor_email' => $vendor_email,
      ':vendor_desc' => $vendor_desc,
      ':shop_name' => $shop_name,
      ':shop_address' => $shop_address,
      ':shop_state' => $shop_state,
      ':shop_city' => $shop_city,
      ':vendor_id' => $vendor_id
    ];
    if ($vendor_profile) {
      $params[':vendor_profile'] = $vendor_profile;
    }
    if ($stmt->execute($params)) {
      $success = "Account updated successfully.";
    } else {
      $error = "Error updating account: " . $stmt->errorInfo()[2];
    }
  }
}

// Fetch vendor info
$conn = getConnection();
$stmt = $conn->prepare("SELECT vendor_name, vendor_email, shop_name, shop_address, shop_state, vendor_desc, shop_city, vendor_profile FROM vendor WHERE vendor_id = :vendor_id");
$stmt->execute([':vendor_id' => $vendor_id]);
$vendor = $stmt->fetch(PDO::FETCH_ASSOC);
?>