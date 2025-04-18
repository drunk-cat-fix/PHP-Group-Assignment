<?php
require_once __DIR__ . '/../Utilities/Connection.php';
$conn = getConnection();
$customer_id = $_SESSION['customer_id'] ?? null;
$error = '';
$success = '';

if (!$customer_id) {
    die("Customer not logged in.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $complaint_against = $_POST['complaint_against'] ?? '';
    $complaint_subject = trim($_POST['complaint_subject'] ?? '');
    $order_id = trim($_POST['order_id'] ?? '');
    $complaint_details = trim($_POST['complaint_details'] ?? '');
    $supporting_file = null;

    // Validate file
    if (!empty($_FILES['attachment']['tmp_name'])) {
        $supporting_file = file_get_contents($_FILES['attachment']['tmp_name']);
    }

    // Validate order_id if provided
    if ($order_id !== '') {
        $stmt = $conn->prepare("SELECT * FROM customer_order WHERE order_id = ? AND customer_id = ?");
        $stmt->execute([$order_id, $customer_id]);
        if (!$stmt->fetch()) {
            $error = "Invalid Order ID.";
        }
    }

    if (!$error) {
        $stmt = $conn->prepare("INSERT INTO complaint (customer_id, complaint_against, complaint_subject, order_id, complaint_details, supporting_file)
                                VALUES (:customer_id, :complaint_against, :complaint_subject, :order_id, :complaint_details, :supporting_file)");
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->bindParam(':complaint_against', $complaint_against);
        $stmt->bindParam(':complaint_subject', $complaint_subject);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':complaint_details', $complaint_details);
        $stmt->bindParam(':supporting_file', $supporting_file, PDO::PARAM_LOB);

        if ($stmt->execute()) {
            $success = "Complaint submitted successfully.";
        } else {
            $error = "Failed to submit complaint.";
        }
    }
}
?>