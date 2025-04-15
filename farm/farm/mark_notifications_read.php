<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("HTTP/1.1 401 Unauthorized");
    exit();
}

// Initialize notifications if not set
if (!isset($_SESSION['notifications'])) {
    $_SESSION['notifications'] = [];
}

// Mark all notifications as read for current user
foreach ($_SESSION['notifications'] as &$notification) {
    if ($notification['user_id'] == $_SESSION['user']['id']) {
        $notification['is_read'] = true;
    }
}

echo json_encode(['success' => true]);
?>