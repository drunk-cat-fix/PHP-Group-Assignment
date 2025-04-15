<?php
session_start();

// Authentication check without database
function checkAuth($role = null) {
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit();
    }
    if ($role && $_SESSION['user']['role'] !== $role) {
        header("Location: index.php");
        exit();
    }
}
?>