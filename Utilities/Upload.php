<?php

session_start();
require_once "../Utilities/Connection.php";

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["avatar"])) {
        $customerId = intval($_POST["customer_id"]);
        $image = file_get_contents($_FILES["avatar"]["tmp_name"]);
        $mimeType = $_FILES["avatar"]["type"];

        // 只允许上传图片
        $allowed = ["image/jpeg", "image/png", "image/gif", "image/webp","image/jpg"];
        if (!in_array($mimeType, $allowed)) {
            die("Unsupported image format");
        }

        // 更新数据库
        $sql = "UPDATE customer SET customer_profile = :image WHERE customer_id = :id";
        $stmt = getConnection()->prepare($sql);
        $image=addslashes($image);
        $stmt->bindParam(":image", $image, PDO::PARAM_LOB);
        $stmt->bindParam(":id", $customerId, PDO::PARAM_INT);
        $stmt->execute();

        echo "Update Profile Success！";
    } else {
        echo "Update Profile failed, Please try again later";
    }

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

