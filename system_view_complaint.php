<?php
session_start();
require_once 'service/System_View_Complaint.php';
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['staff_id'])) {
    header("Location: login.php");
    exit();
}if (isset($_SESSION['admin_id'])) {
require_once 'admin_nav.php';
} else if (isset($_SESSION['staff_id'])) {
require_once 'staff_nav.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Complaints</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            padding: 20px;
            background-color: #f9f9f9;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #4CAF50;
            margin-bottom: 20px;
            font-size: 2.5em;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f1f1f1;
            font-weight: 600;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        th a {
            text-decoration: none;
            color: inherit;
        }

        .solved-yes {
            color: #28a745;
            font-weight: bold;
        }

        .solved-no {
            color: #dc3545;
            font-weight: bold;
        }

        .subject-link {
            color: #007bff;
            text-decoration: none;
        }

        .subject-link:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            color: #fff;
            font-weight: bold;
        }

        .alert-danger {
            background-color: #dc3545;
        }

        .alert-success {
            background-color: #28a745;
        }

    </style>
</head>
<body>

<div class="container">
    <h1>Customer Complaints</h1>

    <?php if (empty($complaints)): ?>
        <div class="alert alert-danger">No complaints found.</div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th><?= sortLink('Complaint ID', 'complaint_id', $sort, $order) ?></th>
                    <th>Customer Name</th>
                    <th><?= sortLink('Subject', 'complaint_subject', $sort, $order) ?></th>
                    <th><?= sortLink('Against', 'complaint_against', $sort, $order) ?></th>
                    <th><?= sortLink('Time', 'complaint_time', $sort, $order) ?></th>
                    <th><?= sortLink('Solved', 'solved', $sort, $order) ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($complaints as $comp): ?>
                    <tr>
                        <td><?= htmlspecialchars($comp['complaint_id']) ?></td>
                        <td><?= htmlspecialchars($comp['customer_name']) ?></td>
                        <td>
                            <a class="subject-link" href="complaint_details.php?complaint_id=<?= $comp['complaint_id'] ?>">
                                <?= htmlspecialchars($comp['complaint_subject']) ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($comp['complaint_against']) ?></td>
                        <td><?= htmlspecialchars($comp['complaint_time']) ?></td>
                        <td class="<?= $comp['solved'] ? 'solved-yes' : 'solved-no' ?>">
                            <?= $comp['solved'] ? 'Yes' : 'No' ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>
