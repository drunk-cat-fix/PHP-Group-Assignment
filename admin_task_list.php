<?php
require_once "service/Admin_Task_List.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Task List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Admin - Task List</h2>
    <a href="admin_add_task.php">
        <button type="button" style="margin-bottom: 15px;">Add Task</button>
    </a>
    <table>
        <thead>
            <tr>
                <th>Task ID</th>
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
</body>
</html>