<?php
session_start();
require_once 'service/System_View_Complaint.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Complaints</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #f7f7f7;
        }
        th a {
            text-decoration: none;
            color: black;
        }
        tr:hover {
            background-color: #f2f2f2;
        }
        .solved-yes {
            color: green;
            font-weight: bold;
        }
        .solved-no {
            color: red;
            font-weight: bold;
        }
        .subject-link {
            color: #007BFF;
            text-decoration: none;
        }
        .subject-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h1>Customer Complaints</h1>

<?php if (empty($complaints)): ?>
    <p style="color: red;">No complaints found.</p>
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

</body>
</html>