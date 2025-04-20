<?php
session_start();
require_once 'service/Complaint_Details.php';
if (isset($_SESSION['admin_id'])) {
require_once 'admin_nav.php';
} else if (isset($_SESSION['staff_id'])) {
require_once 'staff_nav.php';
}
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['staff_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 32px;
            margin-bottom: 30px;
        }

        .complaint-container {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
            max-width: 800px;
        }

        .complaint-container p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .complaint-container p strong {
            color: #333;
        }

        .btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        .btn:hover {
            background-color: #45a049;
        }

        textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 14px;
            resize: vertical;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
            font-size: 16px;
        }

        a:hover {
            text-decoration: underline;
        }

        .image-container {
            text-align: center;
            margin-top: 15px;
        }

        .image-container img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .complaint-container {
                padding: 15px;
            }

            h1 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>

    <h1>Complaint Details</h1>

    <div class="complaint-container">
        <p><strong>Complaint ID:</strong> <?= htmlspecialchars($complaint['complaint_id']) ?></p>
        <p><strong>Customer Name:</strong> <?= htmlspecialchars($complaint['customer_name']) ?></p>
        <p><strong>Subject:</strong> <?= htmlspecialchars($complaint['complaint_subject']) ?></p>
        <p><strong>Against:</strong> <?= htmlspecialchars($complaint['complaint_against']) ?></p>
        <p><strong>Order ID:</strong> <?= htmlspecialchars($complaint['order_id']) ?></p>
        <p><strong>Details:</strong><br><?= nl2br(htmlspecialchars($complaint['complaint_details'])) ?></p>
        <p><strong>Time:</strong> <?= htmlspecialchars($complaint['complaint_time']) ?></p>
        <p><strong>Solved:</strong> <?= $complaint['solved'] ? 'Yes' : 'No' ?></p>

        <?php if (!empty($complaint['supporting_file'])): ?>
            <div class="image-container">
                <p><strong>Supporting Image:</strong><br>
                    <img src="data:image/jpeg;base64,<?= base64_encode($complaint['supporting_file']) ?>" alt="Evidence Image">
                </p>
            </div>
        <?php endif; ?>

        <?php if (!$complaint['solved']): ?>
            <form method="post">
                <label for="admin_reply"><strong>Reply (optional message):</strong></label><br>
                <textarea name="admin_reply" id="admin_reply" rows="4" cols="50"></textarea><br><br>
                <button type="submit" class="btn">Confirm and Mark as Solved</button>
            </form>
        <?php endif; ?>

        <br>
        <a href="system_view_complaint.php">← Back to Complaint List</a>
    </div>

</body>
</html>
