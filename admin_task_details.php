<?php
require_once "service/Admin_Task_Details.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .task-container {
            border: 1px solid #ddd;
            padding: 20px;
            background-color: #f9f9f9;
        }
        button {
            margin-top: 10px;
            padding: 8px 15px;
            border: none;
            cursor: pointer;
        }
        .edit-btn {
            background-color: #4CAF50;
            color: white;
        }
        .back-btn {
            background-color: #ccc;
        }
    </style>
</head>
<body>
    <h2>Task Details</h2>
    <div class="task-container">
        <p><strong>Task ID:</strong> <?php echo htmlspecialchars($task['task_id']); ?></p>
        <p><strong>Task Name:</strong> <?php echo htmlspecialchars($task['task_name']); ?></p>
        <p><strong>Task Description:</strong> <?php echo htmlspecialchars($task['task_desc']); ?></p>
        <p><strong>Start Date:</strong> <?php echo htmlspecialchars($task['task_start_date']); ?></p>
        <p><strong>Due Date:</strong> <?php echo htmlspecialchars($task['task_due_date']); ?></p>
        <p><strong>Complete Date:</strong> <?php echo htmlspecialchars($task['task_done_date'] ?: 'N/A'); ?></p>
        <p><strong>Order ID:</strong> <?php echo htmlspecialchars($task['order_id']); ?></p>
        <button class="edit-btn" onclick="editTask()">Edit Task</button>
        <button class="back-btn" onclick="goBack()">Back</button>
    </div>
    
    <script>
        function editTask() {
            window.location.href = "admin_edit_task.php?task_id=<?php echo $task_id; ?>";
        }
        
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>