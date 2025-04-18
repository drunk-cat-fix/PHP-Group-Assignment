<?php
/**
 * Navigation logic for inclusion in pages
 */
require_once "Utilities/Connection.php";
require_once 'service/Customer_Notification.php';
$notificationCount = count($notifications);

$sql = "SELECT customer_name, customer_profile FROM customer WHERE customer_id = ?";
$stmt = getConnection()->prepare($sql);
$stmt->bindParam(1, $_SESSION['customer_id']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$userName = $row["customer_name"];
$avatarData = $row["customer_profile"];

// Simplified approach for displaying the image
$hasAvatar = !empty($avatarData);
$avatarSrc = $hasAvatar ? 'data:image/jpeg;base64,' . base64_encode($avatarData) : 'images/default-avatar.jpg';

function getImageMimeType($binaryData) {
    if (empty($binaryData)) return 'image/jpeg';

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->buffer($binaryData);

    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    return in_array($mimeType, $allowed) ? $mimeType : 'image/jpeg';
}

$mimeType = getImageMimeType($avatarData);
?>