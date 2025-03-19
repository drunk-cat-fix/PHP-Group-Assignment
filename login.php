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
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>
    <form action="login.php" method="post">
    <input type="text" id="username" placeholder="Enter Username" required>
    <input type="password" id="password" placeholder="Enter Password" required>
    <select id="role">
        <option value="">Select Role</option>
        <option value="admin" name="admin">Admin</option>
        <option value="vendor" name="vendor">Vendor</option>
        <option value="customer" name="customer">Customer</option>
        <option value="staff" name="staff">Staff</option>
    </select>
    <button onclick="login()" type="submit">Login</button>
    </form>
</div>

<script>
    function login() {
        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;
        var role = document.getElementById("role").value;

        if (username === "" || password === "" || role === "") {
            alert("Please fill in all fields.");
            return;
        }

        // Simulating authentication (In real apps, verify with a backend)
        if (username === "admin" && password === "admin123" && role === "admin") {
            window.location.href = "admin_dashboard.html";
        } else if (username === "vendor" && password === "vendor123" && role === "vendor") {
            window.location.href = "vendor_dashboard.html";
        } else if (username === "customer" && password === "customer123" && role === "customer") {
            window.location.href = "customer_dashboard.html";
        } else if (username === "staff" && password === "staff123" && role === "staff") {
            window.location.href = "staff_dashboard.html";
        } else {
            alert("Invalid credentials or role.");
        }
    }
</script>

</body>
</html>

