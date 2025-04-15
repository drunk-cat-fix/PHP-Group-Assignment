<?php
session_start();

if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $users = $_SESSION['users'] ?? [];
    
    // Check if username exists
    if (isset($users[$_POST['username']])) {
        $error = "Username already exists";
    } else {
        $_SESSION['users'][$_POST['username']] = [
            'username' => $_POST['username'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'email' => $_POST['email'],
            'role' => $_POST['role']
        ];
        
        $_SESSION['message'] = "Registration successful! Please login.";
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - AgriMarketplace</title>
    <style>
        /* Similar styling to login.php */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .auth-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .auth-container h2 {
            color: #2e7d32;
            margin-bottom: 25px;
        }
        .auth-form input, .auth-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .auth-form button {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            width: 100%;
            cursor: pointer;
        }
        .auth-links {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <h2>Register for AgriMarketplace</h2>
        <?php if (isset($error)): ?>
            <div style="color:red; margin-bottom:15px;"><?= $error ?></div>
        <?php endif; ?>
        <form class="auth-form" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role" required>
                <option value="customer">Customer</option>
                <option value="vendor">Vendor</option>
            </select>
            <button type="submit">Register</button>
        </form>
        <div class="auth-links">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </div>
</body>
</html>