<?php
session_start();
require_once "service/Admin_Task_Details.php";
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
    <title>Task Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            max-width: 800px;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
        }

        .task-container {
            border-top: 3px solid #28a745;
            padding: 20px;
            color: #555;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            margin: 10px 0;
        }

        p strong {
            color: #333;
        }

        .buttons-container {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        button {
            padding: 12px 25px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .edit-btn {
            background-color: #4CAF50;
            color: white;
        }

        .edit-btn:hover {
            background-color: #45a049;
        }

        .back-btn {
            background-color: #f1f1f1;
            color: #333;
            border: 1px solid #ddd;
        }

        .back-btn:hover {
            background-color: #ddd;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                width: 90%;
            }

            h2 {
                font-size: 24px;
            }

            button {
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Task Details</h2>
    <div class="task-container">
        <p><strong>Task ID:</strong> <?php echo htmlspecialchars($task['task_id']); ?></p>
        <p><strong>Task Name:</strong> <?php echo htmlspecialchars($task['task_name']); ?></p>
        <p><strong>Task Description:</strong> <?php echo htmlspecialchars($task['task_desc']); ?></p>
        <p><strong>Start Date:</strong> <?php echo htmlspecialchars($task['task_start_date']); ?></p>
        <p><strong>Due Date:</strong> <?php echo htmlspecialchars($task['task_due_date']); ?></p>
        <p><strong>Complete Date:</strong> <?php echo htmlspecialchars($task['task_done_date'] ?: 'N/A'); ?></p>
        <p><strong>Order ID:</strong> <?php echo htmlspecialchars($task['order_id']); ?></p>
        <p><strong>Assigned Staff:</strong> <?php echo $staff_names ?: 'No staff assigned'; ?></p>

        <div class="buttons-container">
            <button class="edit-btn" onclick="editTask()">Edit Task</button>
            <button class="back-btn" onclick="goBack()">Back</button>
        </div>
    </div>
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
