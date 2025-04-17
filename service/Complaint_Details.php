<?php
require_once __DIR__ . '/../Utilities/Connection.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($_GET['complaint_id'])) {
    echo "Complaint ID is required.";
    exit;
}

$complaint_id = $_GET['complaint_id'];
$conn = getConnection();

// Get complaint details
$stmt = $conn->prepare("
    SELECT c.*, cust.customer_name, cust.customer_email
    FROM complaint c
    JOIN customer cust ON c.customer_id = cust.customer_id
    WHERE c.complaint_id = ?
");
$stmt->execute([$complaint_id]);
$complaint = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$complaint) {
    echo "Complaint not found.";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_reply'])) {
    // Update as solved
    $updateStmt = $conn->prepare("UPDATE complaint SET solved = 1 WHERE complaint_id = ?");
    $updateStmt->execute([$complaint_id]);

    // Send email
    $to = $complaint['customer_email'];
    $subject = "Your Complaint Has Been Addressed";
    $admin_reply = trim($_POST['admin_reply']);

    $message = "Dear " . $complaint['customer_name'] . ",\n\n";
    $message .= "Your complaint (ID: $complaint_id) has been reviewed and resolved.\n\n";

    if (!empty($admin_reply)) {
        $message .= "Reply from our support team:\n" . $admin_reply . "\n\n";
    }

    $message .= "Thank you for your feedback.\n\nRegards,\nSupport Team";

    // SMTP setup

    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';         // Change this
        $mail->SMTPAuth = true;
        $mail->Username = 'chiajunyit@gmail.com'; // Change this
        $mail->Password = 'qgjw izkg oiet wbqf';   // Change this
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('your_email@example.com', 'Support Team');
        $mail->addAddress($to, $complaint['customer_name']);

        // Content
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
    } catch (Exception $e) {
        echo "Email failed: {$mail->ErrorInfo}";
    }

    $_SESSION['message'] = "Complaint marked as solved and email sent.";
    header("Location: system_view_complaint.php");
    exit;
}
?>