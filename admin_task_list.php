<?php
require_once "service/Admin_Task_List.php";
require_once 'admin_nav.php';
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Task List</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            font-size: 32px;
            color: #333;
            margin-top: 30px;
            margin-bottom: 20px;
        }

        button {
            padding: 10px 20px;
            border: none;
            background-color: #28a745;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-bottom: 20px;
        }

        button:hover {
            background-color: #218838;
        }

        /* Align button with the table */
        .add-task-btn {
            display: inline-block;
            margin-left: 2%;
        }

        table {
            width: 96%;
            margin-left: 2%;
            margin-right: 2%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 40px; /* Added some space at the bottom */
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #28a745;
            color: white;
            text-transform: uppercase;
            font-size: 14px;
        }

        td {
            background-color: #f9f9f9;
            color: #555;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Link Styles */
        a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            h2 {
                font-size: 28px;
            }

            button {
                width: 100%;
                padding: 12px;
            }

            table {
                font-size: 14px;
                margin-left: 10px;
                margin-right: 10px;
            }

            th, td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<h2>Admin - Task List</h2>

<!-- Button aligned with the table -->
<div class="add-task-btn">
    <a href="admin_add_task.php">
        <button type="button">Add Task</button>
    </a>
</div>

<table id="taskTable">
    <thead>
        <tr>
            <th onclick="sortTableByTaskID()" style="cursor:pointer;">Task ID &#9650;</th>
            <th>Task Name</th>
            <th>Task Description</th>
            <th>Start Date</th>
            <th>Due Date</th>
            <th>Complete Date</th>
            <th>Order ID</th>
            <th>Assigned Staff(s)</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?php echo htmlspecialchars($task['task_id']); ?></td>
                <td><a href="admin_task_details.php?task_id=<?php echo $task['task_id']; ?>">
                    <?php echo htmlspecialchars($task['task_name']); ?></a></td>
                <td><?php echo htmlspecialchars($task['task_desc']); ?></td>
                <td><?php echo htmlspecialchars($task['task_start_date']); ?></td>
                <td><?php echo htmlspecialchars($task['task_due_date']); ?></td>
                <td><?php echo htmlspecialchars($task['task_done_date'] ?: 'N/A'); ?></td>
                <td><?php echo htmlspecialchars($task['order_id']); ?></td>
                <td><?= htmlspecialchars($task['assigned_staffs']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
let sortAsc = true;

function sortTableByTaskID() {
    const table = document.getElementById("taskTable");
    const rows = Array.from(table.rows).slice(1); // skip header row
    const tbody = table.tBodies[0];

    rows.sort((a, b) => {
        const idA = parseInt(a.cells[0].innerText.trim());
        const idB = parseInt(b.cells[0].innerText.trim());
        return sortAsc ? idA - idB : idB - idA;
    });

    // Toggle arrow direction in header
    const th = table.tHead.rows[0].cells[0];
    th.innerHTML = sortAsc ? 'Task ID &#9660;' : 'Task ID &#9650;';

    // Re-add rows in new order
    rows.forEach(row => tbody.appendChild(row));

    sortAsc = !sortAsc;
}
</script>
</body>
</html>
