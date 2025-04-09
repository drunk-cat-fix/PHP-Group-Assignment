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
        }
        
        function confirmSave() {
            if (confirm("Are you sure you want to save changes?")) {
                let taskUpdates = [];
                let progressUpdates = [];

                // Get task status updates
                document.querySelectorAll(".complete-date-select").forEach(select => {
                    if (select.value === "Done") {
                        let taskId = select.closest("tr").querySelector("td:first-child").innerText;
                        taskUpdates.push(taskId);
                    }
                });

                // Get progress updates
                document.querySelectorAll(".progress-input").forEach(input => {
                    if (input.dataset.original !== input.value) {
                        let taskId = input.closest("tr").querySelector("td:first-child").innerText;
                        let orderId = input.dataset.orderid;
                        if (orderId) {
                            progressUpdates.push({
                                order_id: orderId,
                                progress: input.value
                            });
                        }
                    }
                });

                fetch("service/Staff_Dashboard.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ 
                        task_updates: taskUpdates,
                        progress_updates: progressUpdates
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("✅ Changes saved successfully!");
                        location.reload();
                    } else {
                        alert("❌ Failed to update tasks.");
                    }
                })
                .catch(error => console.error("Error:", error));
            }
        }
        
        function cancelChanges() {
            location.reload();
        }

        function updateProgressValue(inputElement) {
            document.getElementById("save-cancel-container").classList.remove("hidden");
    
            // Get the task row
            const row = inputElement.closest("tr");
            const selectElement = row.querySelector(".complete-date-select");
            const doneOption = selectElement ? selectElement.querySelector("option[value='Done']") : null;
            const progressValue = parseInt(inputElement.value);
    
            // If progress is 100%, enable the select and the Done option, otherwise disable them
            if (selectElement) {
                if (progressValue >= 100) {
                    selectElement.disabled = false;
                    if (doneOption) doneOption.disabled = false;
            
                    // Remove the warning message if it exists
                    const warningMsg = row.querySelector("small");
                    if (warningMsg) warningMsg.style.display = "none";
                } else {
                    selectElement.disabled = true;
                    if (doneOption) doneOption.disabled = true;
            
                    // Add or show the warning message
                    let warningMsg = row.querySelector("small");
                    if (!warningMsg) {
                        warningMsg = document.createElement("small");
                        warningMsg.style.color = "red";
                        warningMsg.style.display = "block";
                        warningMsg.textContent = "Requires 100% progress";
                        selectElement.parentNode.appendChild(warningMsg);
                    } else {
                        warningMsg.style.display = "block";
                    }
                }
            }
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
                            <select class="complete-date-select" onchange="updateCompleteDate(this)" <?php echo (!empty($task['order_id']) && (!isset($task['deliver_percent']) || $task['deliver_percent'] < 100)) ? 'disabled' : ''; ?>>
                                <option value="Incomplete" selected>Incomplete</option>
                                <option value="Done" <?php echo (!empty($task['order_id']) && (!isset($task['deliver_percent']) || $task['deliver_percent'] < 100)) ? 'disabled' : ''; ?>>Done</option>
                            </select>
                            <?php if (!empty($task['order_id']) && (!isset($task['deliver_percent']) || $task['deliver_percent'] < 100)): ?>
                                <small style="color: red; display: block;">Requires 100% progress</small>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($task['staff_name']); ?></td>
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