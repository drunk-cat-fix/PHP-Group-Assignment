<?php
class Notification {
    public static function create($userId, $title, $message) {
        if (!isset($_SESSION['notifications'])) {
            $_SESSION['notifications'] = [];
        }
        
        $_SESSION['notifications'][] = [
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'is_read' => false,
            'created_at' => time()
        ];
    }

    public static function getUnreadCount($userId) {
        if (!isset($_SESSION['notifications'])) {
            return 0;
        }
        
        $count = 0;
        foreach ($_SESSION['notifications'] as $notification) {
            if ($notification['user_id'] == $userId && !$notification['is_read']) {
                $count++;
            }
        }
        return $count;
    }

    public static function markAsRead($notificationId, $userId) {
        if (isset($_SESSION['notifications'][$notificationId])) {
            $_SESSION['notifications'][$notificationId]['is_read'] = true;
        }
    }

    public static function getUserNotifications($userId, $limit = 10) {
        if (!isset($_SESSION['notifications'])) {
            return [];
        }
        
        $userNotifications = [];
        foreach ($_SESSION['notifications'] as $notification) {
            if ($notification['user_id'] == $userId) {
                $userNotifications[] = $notification;
            }
        }
        
        usort($userNotifications, function($a, $b) {
            return $b['created_at'] - $a['created_at'];
        });
        
        return array_slice($userNotifications, 0, $limit);
    }
}

class Alert {
    public static function checkLowStock($vendorId) {
        // Simulate low stock check - in a real app this would check products
        $threshold = 10;
        
        // For demo, just create a sample notification
        $title = "Low Stock Alert";
        $message = "Your product 'Sample Product' is running low (Quantity: 5). Please consider restocking.";
        Notification::create($vendorId, $title, $message);
    }
}
?>