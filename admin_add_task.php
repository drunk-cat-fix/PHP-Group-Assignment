<?php
session_start();
require_once 'service/Admin_Add_Task.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Add Task</title>
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
        .task-section {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }
        /* Styling for selected staff display */
        .selected-staff {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            margin: 5px;
            border-radius: 5px;
            cursor: pointer;
        }
        .selected-staff:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>    
    <div class="task-section">
        <h3>Add Task</h3>
        <!-- Debug Messages -->
        <?php if (!empty($_SESSION['debug_log'])): ?>
            <div style="margin: 20px; padding: 15px; border: 1px solid #ccc; background: #f9f9f9;">
                <h3>Debug Information:</h3>
                <ol>
                    <?php foreach ($_SESSION['debug_log'] as $message): ?>
                        <li><?php echo htmlspecialchars($message); ?></li>
                    <?php endforeach; ?>
                </ol>
            </div>
            <?php 
            // Clear debug log after displaying
            $_SESSION['debug_log'] = [];
            ?>
        <?php endif; ?>
        <form id="addTaskForm" action="service/Admin_Add_Task.php" method="POST">
            <label for="task_name">Task Name</label>
            <input type="text" id="task_name" name="task_name" value="<?php echo htmlspecialchars($taskName); ?>" required><br>
            <label for="task_desc">Task Description</label>
            <textarea id="task_desc" name="task_desc" required><?php echo htmlspecialchars($taskDesc); ?></textarea><br>
            <label for="task_start_date">Start Date</label>
            <input type="date" id="task_start_date" name="task_start_date" value="<?php echo $taskStartDate; ?>" required><br>
            <label for="task_due_date">Due Date</label>
            <input type="date" id="task_due_date" name="task_due_date" value="<?php echo $taskDueDate; ?>" required><br>
            <label for="assigned_staff">Assign Staff</label>
            <select id="assigned_staff">
                <option value="">Select Staff</option>
                <?php foreach ($staffList as $staff): ?>
                    <option value="<?php echo $staff['staff_id']; ?>"><?php echo htmlspecialchars($staff['staff_name']); ?></option>
                <?php endforeach; ?>
            </select>
            <button type="button" id="addStaffBtn" disabled>Add</button>
            <br>
            <p id="selectedStaffText" style="display: none;"><strong>Selected Staffs:</strong></p>
            <div id="selectedStaffContainer"></div>
            <div id="hiddenInputsContainer"></div>
            
            <?php if(isset($orderId)): ?>
            <input type="hidden" name="order_id" value="<?php echo $orderId; ?>">
            <?php endif; ?>
            
            <button type="submit">Add Task</button>
        </form>
    </div>
    <?php if (isset($_GET['errMsg'])): ?>
        <div style="color: red; padding: 10px; margin: 10px 0; background-color: #ffeeee; border: 1px solid #ffcccc;">
            Error: <?php echo htmlspecialchars($_GET['errMsg']); ?>
        </div>
    <?php endif; ?>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const assignedStaffSelect = document.getElementById("assigned_staff");
        const addStaffBtn = document.getElementById("addStaffBtn");
        const selectedStaffContainer = document.getElementById("selectedStaffContainer");
        const selectedStaffText = document.getElementById("selectedStaffText");
        const hiddenInputsContainer = document.getElementById("hiddenInputsContainer");
        let selectedStaffs = {};
    
        assignedStaffSelect.addEventListener("change", function () {
            addStaffBtn.disabled = assignedStaffSelect.value === "";
        });
    
        addStaffBtn.addEventListener("click", function () {
            const selectedValue = assignedStaffSelect.value;
            const selectedText = assignedStaffSelect.options[assignedStaffSelect.selectedIndex].text;
        
            if (!selectedValue || selectedStaffs[selectedValue]) return;
        
            selectedStaffs[selectedValue] = selectedText;
            addStaffToDisplay(selectedValue, selectedText);
        
            addHiddenInput(selectedValue);
        
            selectedStaffText.style.display = "block";
            assignedStaffSelect.value = "";
            addStaffBtn.disabled = true;
        });
    
        function addStaffToDisplay(value, text) {
            const staffItem = document.createElement("span");
            staffItem.textContent = text;
            staffItem.classList.add("selected-staff");
            staffItem.dataset.value = value;
        
            staffItem.addEventListener("click", function () {
                delete selectedStaffs[value];
                staffItem.remove();
            
                const hiddenInput = document.getElementById("staff_" + value);
                if (hiddenInput) {
                    hiddenInput.remove();
                }
            
                if (Object.keys(selectedStaffs).length === 0) {
                    selectedStaffText.style.display = "none";
                }
            });
        
            selectedStaffContainer.appendChild(staffItem);
        }
    
        function addHiddenInput(value) {
            const inputId = "staff_" + value;
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "assigned_staff[]"; 
            input.value = value;
            input.id = inputId;
            hiddenInputsContainer.appendChild(input);
        }
    });

    document.getElementById("addTaskForm").addEventListener("submit", function(e) {
        const taskName = document.getElementById("task_name").value.trim();
        const taskDesc = document.getElementById("task_desc").value.trim();
        const startDate = document.getElementById("task_start_date").value;
        const dueDate = document.getElementById("task_due_date").value;
    
        // Check if any staff is selected
        const staffInputs = document.querySelectorAll('input[name="assigned_staff[]"]');
        if (staffInputs.length === 0) {
            e.preventDefault();
            alert("Please select at least one staff member");
            return;
        }
        if (!taskName || !taskDesc || !startDate || !dueDate) {
            e.preventDefault();
            alert("Please fill in all required fields");
            return;
        }
    
        // Validate dates
        const start = new Date(startDate);
        const due = new Date(dueDate);
    
        if (due < start) {
            e.preventDefault();
            alert("Due date cannot be before start date");
            return;
        }
    });
    </script>
</body>
</html>