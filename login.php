<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            animation: fadeIn 1.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .login-container {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            width: 320px;
            text-align: center;
            animation: slideUp 0.8s ease-in-out;
        }

        @keyframes slideUp {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        h2 {
            margin-bottom: 15px;
            color: #333;
        }

        input, button {
            width: 80%;
            padding: 12px;
            margin: 8px 0;
            border: 2px solid #ccc;
            border-radius: 6px;
            transition: all 0.3s ease-in-out;
        }

        select{
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 2px solid #ccc;
            border-radius: 6px;
            transition: all 0.3s ease-in-out;

        }

        input:focus, select:focus {
            border-color: #667eea;
            outline: none;
            box-shadow: 0px 0px 8px rgba(102, 126, 234, 0.5);
        }

        button {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        button:hover {
            background: linear-gradient(135deg, #5a67d8, #6b46c1);
            box-shadow: 0px 4px 10px rgba(103, 58, 183, 0.4);
        }
        button:active {
            transform: scale(0.95);
        }

        .error {
            animation: shake 0.3s ease-in-out;
            border-color: red !important;
            box-shadow: 0px 0px 8px rgba(255, 0, 0, 0.5) !important;
        }

        @keyframes shake {
            0% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            50% { transform: translateX(5px); }
            75% { transform: translateX(-5px); }
            100% { transform: translateX(0); }
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>
    <form id="loginForm" action="login.php" method="post">
        <input type="text" id="username" placeholder="Enter Username" required>
        <input type="password" id="password" placeholder="Enter Password" required>
        <select id="role">
            <option value="">Select Role</option>
            <option value="admin">Admin</option>
            <option value="vendor">Vendor</option>
            <option value="customer">Customer</option>
            <option value="staff">Staff</option>
        </select>
        <button type="submit" onclick="return login()">Login</button>
    </form>
</div>

<script>
    function login() {
        var username = document.getElementById("username");
        var password = document.getElementById("password");
        var role = document.getElementById("role");

        if (username.value === "" || password.value === "" || role.value === "") {
            alert("❗ Please fill in all fields.");
            return false;
        }

        if (username.value === "admin" && password.value === "admin123" && role.value === "admin") {
            window.location.href = "admin_dashboard.html";
        } else if (username.value === "vendor" && password.value === "vendor123" && role.value === "vendor") {
            window.location.href = "vendor_dashboard.html";
        } else if (username.value === "customer" && password.value === "customer123" && role.value === "customer") {
            window.location.href = "customer_dashboard.html";
        } else if (username.value === "staff" && password.value === "staff123" && role.value === "staff") {
            window.location.href = "staff_dashboard.html";
        } else {
            showError(username);
            showError(password);
            showError(role);
            alert("❌ Invalid credentials or role.");
            return false;
        }
    }

    function showError(element) {
        element.classList.add("error");
        setTimeout(() => element.classList.remove("error"), 1000);
    }
</script>

</body>
</html>
