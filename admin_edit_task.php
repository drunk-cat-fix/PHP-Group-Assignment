<?php
session_start();
require_once "service/Admin_Edit_Task.php";
require_once 'admin_nav.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 30px;
            background-color: #f0f2f5;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .task-container {
            max-width: 700px;
            margin: auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
        }

        input[type="text"],
        input[type="date"],
        textarea,
        select {
            width: 100%;
            padding: 10px 12px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        textarea {
            resize: vertical;
            height: 100px;
        }

        .btn-group {
            margin-top: 20px;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        button {
            padding: 10px 20px;
            border: none;
            font-weight: bold;
            font-size: 14px;
            border-radius: 6px;
            cursor: pointer;
        }

        .save-btn {
            background-color: #28a745;
            color: white;
        }

        .cancel-btn {
            background-color: #dee2e6;
            color: #333;
        }

        .staff-selection {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .selected-staff {
            display: inline-block;
            background-color: #e2e6ea;
            color: #333;
            padding: 6px 12px;
            margin: 5px 5px 0 0;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
        }

        #selectedStaffText {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Edit Task</h2>
    <div class="task-container">
        <form id="editTaskForm" action="service/Admin_Edit_Task.php" method="POST">
            <input type="hidden" name="task_id" value="<?= htmlspecialchars($task['task_id']); ?>">

            <label for="task_name">Task Name</label>
            <input type="text" name="task_name" id="task_name" value="<?= htmlspecialchars($task['task_name']); ?>" required>

            <label for="task_desc">Task Description</label>
            <textarea name="task_desc" id="task_desc" required><?= htmlspecialchars($task['task_desc']); ?></textarea>

            <label for="task_start_date">Start Date</label>
            <input type="date" name="task_start_date" id="task_start_date" value="<?= htmlspecialchars($task['task_start_date']); ?>" required>

            <label for="task_due_date">Due Date</label>
            <input type="date" name="task_due_date" id="task_due_date" value="<?= htmlspecialchars($task['task_due_date']); ?>" required>

            <label for="assigned_staff">Assign Staff</label>
            <div class="staff-selection">
                <select id="assigned_staff">
                    <option value="">Select Staff</option>
                    <?php foreach ($staffList as $staff): ?>
                        <option value="<?= $staff['staff_id']; ?>"><?= htmlspecialchars($staff['staff_name']); ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="button" id="addStaffBtn" disabled>Add</button>
            </div>

            <p id="selectedStaffText" style="display: none;">Selected Staffs:</p>
            <div id="selectedStaffContainer"></div>
            <div id="hiddenInputsContainer"></div>

            <div class="btn-group">
                <button type="submit" class="save-btn">Save Changes</button>
                <button type="button" class="cancel-btn" onclick="window.history.back();">Cancel</button>
            </div>
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

        assignedStaffSelect.addEventListener("change", () => {
            addStaffBtn.disabled = assignedStaffSelect.value === "";
        });

        addStaffBtn.addEventListener("click", () => {
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

            staffItem.addEventListener("click", () => {
                delete selectedStaffs[value];
                staffItem.remove();

                const hiddenInput = document.getElementById("staff_" + value.replace(/\s+/g, '_'));
                if (hiddenInput) hiddenInput.remove();

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
