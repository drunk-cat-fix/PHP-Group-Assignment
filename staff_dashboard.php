<?php
session_start();
require_once 'service/Staff_Dashboard.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff - Task List</title>
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
            cursor: pointer;
        }
        .hidden {
            display: none;
        }
        .progress-input {
            width: 60px;
        }
    </style>
    <script>
        function updateCompleteDate(selectElement) {
            document.getElementById("save-cancel-container").classList.remove("hidden");
        }
        
        function updateProgressValue(inputElement) {
            document.getElementById("save-cancel-container").classList.remove("hidden");

            // Get the task row and task ID
            const row = inputElement.closest("tr");
            const taskId = row.querySelector("td:first-child").innerText;
            const progressValue = parseInt(inputElement.value);

            // Find the complete date display element
            const completeDateDisplay = document.getElementById(`complete-date-${taskId}`);

            // If progress is 100%, set the complete date to "Done", otherwise "Incomplete"
            if (completeDateDisplay) {
                if (progressValue >= 100) {
                    completeDateDisplay.textContent = "Done";
                    completeDateDisplay.dataset.status = "Done";
                } else {
                    completeDateDisplay.textContent = "Incomplete";
                    completeDateDisplay.dataset.status = "Incomplete";
                }
            }
        }
        
        function confirmSave() {
            if (confirm("Are you sure you want to save changes?")) {
                let progressUpdates = [];
                let progressTaskIds = [];

                // Get progress updates
                document.querySelectorAll(".progress-input").forEach(input => {
                    if (input.dataset.original !== input.value) {
                        let orderId = input.dataset.orderid;
                        if (orderId) {
                            progressUpdates.push({
                                order_id: parseInt(orderId),
                                progress: parseInt(input.value)
                            });
                        }
                    }
                });

                // Get task completions from select elements (for tasks without progress)
                let taskIds = [];
                document.querySelectorAll(".complete-date-select").forEach(select => {
                    if (select.value === "Done") {
                        let taskId = select.closest("tr").querySelector("td:first-child").innerText;
                        taskIds.push(parseInt(taskId));
                    }
                });

                // Create a promise to track all updates
                let allPromises = [];
        
                // Add progress updates promise if needed
                if (progressUpdates.length > 0) {
                    allPromises.push(sendProgressUpdates(progressUpdates));
                }
        
                // Add task updates promise if needed
                if (taskIds.length > 0) {
                    allPromises.push(sendTaskUpdates(taskIds));
                }
        
                if (allPromises.length > 0) {
                    Promise.all(allPromises)
                        .then(results => {
                            // Check if all results were successful
                            const allSuccessful = results.every(result => result.success);
                    
                            if (allSuccessful) {
                                alert("✅ All changes saved successfully!");
                            } else {
                                // If any update failed, alert the user
                                alert("❌ Some updates couldn't be completed. Please check the data and try again.");
                            }
                    
                            // Reload the page regardless
                            location.reload();
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            alert("❌ An error occurred while saving changes");
                            location.reload();
                        });
                } else {
                    alert("No changes detected to save.");
                }
            }
        }

        function sendProgressUpdates(progressUpdates) {
            return fetch("service/Staff_Dashboard.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ 
                    action: "updateDeliveryProgress",
                    progressUpdates: progressUpdates
                })
            })
            .then(response => response.json());
        }
        
        function cancelChanges() {
            location.reload();
        }

        function updateProgressValue(inputElement) {
            document.getElementById("save-cancel-container").classList.remove("hidden");
    
            // Get the task row and task ID
            const row = inputElement.closest("tr");
            const taskId = row.querySelector("td:first-child").innerText;
            const progressValue = parseInt(inputElement.value);
    
            // Find the complete date display element
            const completeDateDisplay = document.getElementById(`complete-date-${taskId}`);
    
            // If progress is 100%, set the complete date to "Done", otherwise "Incomplete"
            if (completeDateDisplay) {
                if (progressValue >= 100) {
                    completeDateDisplay.textContent = "Done";
                    completeDateDisplay.dataset.status = "Done";
                } else {
                    completeDateDisplay.textContent = "Incomplete";
                    completeDateDisplay.dataset.status = "Incomplete";
                }
            }
        }
        function sendTaskUpdates(taskIds) {
            return fetch("service/Staff_Dashboard.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ 
                    action: "updateTaskStatus",
                    taskIds: taskIds
                })
            })
            .then(response => response.json());
        }
    </script>
</head>
<body>
    <h2>Staff - Task List</h2>
    <table>
        <thead>
            <tr>
                <th>Task ID</th>
                <th>Task Name</th>
                <th>Task Description</th>
                <th>Start Date</th>
                <th>Due Date</th>
                <th>Progress</th>
                <th>Complete Date</th>
                <th>Assigned Staff</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?php echo htmlspecialchars($task['task_id']); ?></td>
                    <td><?php echo htmlspecialchars($task['task_name']); ?></td>
                    <td><?php echo htmlspecialchars($task['task_desc']); ?></td>
                    <td><?php echo htmlspecialchars($task['task_start_date']); ?></td>
                    <td><?php echo htmlspecialchars($task['task_due_date']); ?></td>
                    <td>
                        <?php if (!empty($task['order_id']) && isset($task['deliver_percent'])): ?>
                            <input type="number" class="progress-input" min="0" max="100" 
                                value="<?php echo htmlspecialchars($task['deliver_percent']); ?>" 
                                data-original="<?php echo htmlspecialchars($task['deliver_percent']); ?>"
                                data-orderid="<?php echo htmlspecialchars($task['order_id']); ?>"
                                onchange="updateProgressValue(this)" 
                                <?php echo !empty($task['task_done_date']) ? 'disabled' : ''; ?>>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($task['task_done_date'])): ?>
                            <?php echo htmlspecialchars($task['task_done_date']); ?>
                        <?php else: ?>
                            <?php if (!empty($task['order_id']) && isset($task['deliver_percent'])): ?>
                                <span class="complete-date-display" 
                                      id="complete-date-<?php echo $task['task_id']; ?>"
                                      data-status="<?php echo ($task['deliver_percent'] >= 100) ? 'Done' : 'Incomplete'; ?>">
                                    <?php echo ($task['deliver_percent'] >= 100) ? 'Done' : 'Incomplete'; ?>
                                </span>
                            <?php else: ?>
                                <select class="complete-date-select" onchange="updateCompleteDate(this)">
                                    <option value="Incomplete" selected>Incomplete</option>
                                    <option value="Done">Done</option>
                                </select>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($task['assigned_staff']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <div id="save-cancel-container" class="hidden">
        <button onclick="confirmSave()">Save Changes</button>
        <button onclick="cancelChanges()">Cancel</button>
    </div>
</body>
</html>