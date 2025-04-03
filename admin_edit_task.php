<?php
session_start();
require_once "service/Admin_Edit_Task.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .task-container { border: 1px solid #ddd; padding: 20px; background-color: #f9f9f9; }
        label { display: block; margin-top: 10px; }
        input, textarea, select { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; }
        button { margin-top: 10px; padding: 8px 15px; border: none; cursor: pointer; }
        .save-btn { background-color: #4CAF50; color: white; }
        .cancel-btn { background-color: #ccc; }
    </style>
</head>
<body>
    <h2>Edit Task</h2>
    <div class="task-container">
        <form id="editTaskForm" action="service/Admin_Edit_Task.php" method="POST">
            <input type="hidden" name="task_id" value="<?php echo htmlspecialchars($task['task_id']); ?>">
            
            <label for="task_name">Task Name</label>
            <input type="text" name="task_name" id="task_name" value="<?php echo htmlspecialchars($task['task_name']); ?>" required>
            
            <label for="task_desc">Task Description</label>
            <textarea name="task_desc" id="task_desc" required><?php echo htmlspecialchars($task['task_desc']); ?></textarea>
            
            <label for="task_start_date">Start Date</label>
            <input type="date" name="task_start_date" id="task_start_date" value="<?php echo htmlspecialchars($task['task_start_date']); ?>" required>
            
            <label for="task_due_date">Due Date</label>
            <input type="date" name="task_due_date" id="task_due_date" value="<?php echo htmlspecialchars($task['task_due_date']); ?>" required>
            
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
            
            <button type="submit" class="save-btn">Save Changes</button>
            <button type="button" class="cancel-btn" onclick="window.history.back();">Cancel</button>
        </form>
    </div>
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
            staffItem.style.margin = "5px";
            staffItem.style.padding = "3px 8px";
            staffItem.style.backgroundColor = "#f0f0f0";
            staffItem.style.borderRadius = "3px";
            staffItem.style.cursor = "pointer";
        
            staffItem.addEventListener("click", function () {
                delete selectedStaffs[value];
                staffItem.remove();
            
                const hiddenInput = document.getElementById("staff_" + value.replace(/\s+/g, '_'));
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
            const inputId = "staff_" + value.replace(/\s+/g, '_');
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "assigned_staff[]";
            input.value = value;
            input.id = inputId;
            hiddenInputsContainer.appendChild(input);
        }
    });
    </script>
</body>
</html>
