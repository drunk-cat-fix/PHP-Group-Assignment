<?php
session_start();
require_once 'service/Complaint_Details.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Complaint Details</title>
</head>
<body>
<h1>Complaint Details</h1>

<p><strong>Complaint ID:</strong> <?= htmlspecialchars($complaint['complaint_id']) ?></p>
<p><strong>Customer Name:</strong> <?= htmlspecialchars($complaint['customer_name']) ?></p>
<p><strong>Subject:</strong> <?= htmlspecialchars($complaint['complaint_subject']) ?></p>
<p><strong>Against:</strong> <?= htmlspecialchars($complaint['complaint_against']) ?></p>
<p><strong>Order ID:</strong> <?= htmlspecialchars($complaint['order_id']) ?></p>
<p><strong>Details:</strong><br><?= nl2br(htmlspecialchars($complaint['complaint_details'])) ?></p>
<p><strong>Time:</strong> <?= htmlspecialchars($complaint['complaint_time']) ?></p>
<p><strong>Solved:</strong> <?= $complaint['solved'] ? 'Yes' : 'No' ?></p>

<?php if (!empty($complaint['supporting_file'])): ?>
    <p><strong>Supporting Image:</strong><br>
        <img src="data:image/jpeg;base64,<?= base64_encode($complaint['supporting_file']) ?>" width="300" alt="Evidence Image">
    </p>
<?php endif; ?>

<?php if (!$complaint['solved']): ?>
    <form method="post">
        <label for="admin_reply">Reply (optional message):</label><br>
        <textarea name="admin_reply" id="admin_reply" rows="4" cols="50"></textarea><br><br>
        <button type="submit">Confirm and Mark as Solved</button>
    </form>
<?php endif; ?>

<br>
<a href="system_view_complaint.php">← Back to Complaint List</a>

</body>
</html>
