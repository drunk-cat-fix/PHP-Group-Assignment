<?php
require_once 'db.php';
session_start();

if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Hardcoded demo user
    if ($username === 'testuser' && $password === 'testpass') {
        $_SESSION['user'] = [
            'id' => 1,
            'username' => 'testuser',
            'role' => 'user'
        ];
        header("Location: index.php");
        exit();
    } else {
        $error = "Use 'testuser'/'testpass' to login";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - AgriMarketplace</title>
</head>
<body>
    <div class="auth-container">
        <h2>Login to AgriMarketplace (Demo)</h2>
        <?php if (isset($error)): ?>
            <div style="color:red; margin-bottom:15px;"><?= $error ?></div>
        <?php endif; ?>
        <form class="auth-form" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <div class="auth-links">
            New user? <a href="register.php">Register here</a>
        </div>
    </div>
</body>
</html>