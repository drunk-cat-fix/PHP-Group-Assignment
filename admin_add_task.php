<?php
session_start();
require_once 'admin_nav.php';
require_once 'service/Admin_Add_Task.php';
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Add Task</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 20px;
        }

        .task-section {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h3 {
            text-align: center;
            color: #333;
        }

        form {
            display: grid;
            gap: 15px;
        }

        label {
            font-weight: 600;
        }

        input[type="text"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        button[type="submit"] {
            background-color: #28a745;
            color: white;
        }

        #addStaffBtn {
            background-color: #007bff;
            color: white;
        }

        .cancel-btn {
            background-color: #dc3545;
            color: white;
        }

        .selected-staff {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 6px 12px;
            margin: 5px 5px 0 0;
            border-radius: 20px;
            cursor: pointer;
        }

        .debug-log {
            background-color: #fff3cd;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ffeeba;
            border-radius: 5px;
        }

        .error-box {
            color: red;
            padding: 10px;
            margin: 10px 0;
            background-color: #ffeeee;
            border: 1px solid #ffcccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <br />
    <div class="task-section">
        <h3>Add Task</h3>

        <?php if (!empty($_SESSION['debug_log'])): ?>
            <div class="debug-log">
                <strong>Debug Info:</strong>
                <ul>
                    <?php foreach ($_SESSION['debug_log'] as $msg): ?>
                        <li><?= htmlspecialchars($msg) ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php $_SESSION['debug_log'] = []; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['errMsg'])): ?>
            <div class="error-box">
                Error: <?= htmlspecialchars($_GET['errMsg']) ?>
            </div>
        <?php endif; ?>

        <form id="addTaskForm" action="service/Admin_Add_Task.php" method="POST">
            <label for="task_name">Task Name</label>
            <input type="text" id="task_name" name="task_name" value="<?= htmlspecialchars($taskName) ?>" required>

            <label for="task_desc">Task Description</label>
            <textarea id="task_desc" name="task_desc" required><?= htmlspecialchars($taskDesc) ?></textarea>

            <label for="task_start_date">Start Date</label>
            <input type="date" id="task_start_date" name="task_start_date" value="<?= $taskStartDate ?>" required>

            <label for="task_due_date">Due Date</label>
            <input type="date" id="task_due_date" name="task_due_date" value="<?= $taskDueDate ?>" required>

            <label for="assigned_staff">Assign Staff</label>
            <div style="display: flex; gap: 10px;">
                <select id="assigned_staff">
                    <option value="">Select Staff</option>
                    <?php foreach ($staffList as $staff): ?>
                        <option value="<?= $staff['staff_id'] ?>"><?= htmlspecialchars($staff['staff_name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="button" id="addStaffBtn" disabled>Add</button>
            </div>

            <p id="selectedStaffText" style="display:none;"><strong>Selected Staff:</strong></p>
            <div id="selectedStaffContainer"></div>
            <div id="hiddenInputsContainer"></div>

            <?php if (isset($orderId)): ?>
                <input type="hidden" name="order_id" value="<?= $orderId ?>">
            <?php endif; ?>

            <div class="form-buttons">
                <button type="submit">Add Task</button>
                <button type="button" class="cancel-btn" onclick="window.location.href='admin_manage_order.php'">Cancel</button>
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

        assignedStaffSelect.addEventListener("change", function () {
            addStaffBtn.disabled = !assignedStaffSelect.value;
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
                if (hiddenInput) hiddenInput.remove();

                if (Object.keys(selectedStaffs).length === 0) {
                    selectedStaffText.style.display = "none";
                }
            });

            selectedStaffContainer.appendChild(staffItem);
        }

        function addHiddenInput(value) {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "assigned_staff[]";
            input.value = value;
            input.id = "staff_" + value;
            hiddenInputsContainer.appendChild(input);
        }
    });

    document.getElementById("addTaskForm").addEventListener("submit", function(e) {
        const taskName = document.getElementById("task_name").value.trim();
        const taskDesc = document.getElementById("task_desc").value.trim();
        const startDate = document.getElementById("task_start_date").value;
        const dueDate = document.getElementById("task_due_date").value;

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

        if (new Date(dueDate) < new Date(startDate)) {
            e.preventDefault();
            alert("Due date cannot be before start date");
        }
    });
    </script>
</body>
</html>
