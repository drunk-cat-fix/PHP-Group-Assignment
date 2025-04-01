<?php
session_start();
require_once "Utilities/Connection.php";

$sql = "SELECT customer_name, customer_profile FROM customer WHERE customer_id = ?";
$stmt = getConnection()->prepare($sql);
$stmt->bindParam(1, $_SESSION['customer_id']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$userName = $row["customer_name"];
$avatarData = $row["customer_profile"];
$avatarData=stripslashes($avatarData);
function getImageMimeType($binaryData) {
    if (empty($binaryData)) return 'image/jpeg';

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->buffer($binaryData);

    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    return in_array($mimeType, $allowed) ? $mimeType : 'image/jpeg';
}

$mimeType = getImageMimeType($avatarData);
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>Index Page</title>
    <style>
        .avatar-container {
            text-align: center;
            margin-top: 50px;
        }
        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            cursor: pointer;
            border: 2px solid #ddd;
            transition: transform 0.3s ease;
        }
        .avatar:hover {
            transform: scale(1.1);
        }
        .welcome {
            font-size: 24px;
            margin: 20px 0;
        }
        input[type="file"] {
            display: none;
        }
        /* 模态框 */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            position: relative;
        }
        .modal img {
            width: 300px;
            height: 300px;
            border-radius: 10px;
            object-fit: cover;
        }
        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="avatar-container">
    <label for="upload-avatar">
        <?php if (!empty($avatarData)): ?>
            <img id="avatar-img" class="avatar"
                 src="data:<?= $mimeType ?>;base64,<?= base64_encode($avatarData) ?>"
                 alt="<?= htmlspecialchars($userName) ?> ` profile" >
        <?php else: ?>
            <img id="avatar-img" class="avatar" src="image/default.jpg" alt="Default Profile">
        <?php endif; ?>
    </label>

    <input type="file" id="upload-avatar" accept="image/*">

    <div class="welcome">Welcome <?= htmlspecialchars($userName) ?>!</div>
</div>

<!-- 头像预览模态框 -->
<div id="previewModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <img id="preview-img" src="" alt="Preview Profile">
        <button id="upload-button">Upload</button>
    </div>
</div>

<script>
    document.getElementById("avatar-img").addEventListener("click", function () {
        const modal = document.getElementById("previewModal");
        const previewImg = document.getElementById("preview-img");
        previewImg.src = this.src;  // 设置预览图片
        modal.style.display = "flex";
    });

    // 关闭模态框
    document.querySelector(".close").addEventListener("click", function () {
        document.getElementById("previewModal").style.display = "none";
    });

    // 监听文件选择
    document.getElementById("upload-avatar").addEventListener("change", function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById("preview-img").src = e.target.result;
            };
            reader.readAsDataURL(file);

            // 显示模态框
            document.getElementById("previewModal").style.display = "flex";
        }
    });

    // 上传新头像
    document.getElementById("upload-button").addEventListener("click", function () {
        const fileInput = document.getElementById("upload-avatar");
        const file = fileInput.files[0];

        if (!file) {
            alert("Please Select Image Firstly ！");
            return;
        }

        const formData = new FormData();
        formData.append("avatar", file);
        formData.append("customer_id", <?= $_SESSION['customer_id'] ?>);

        fetch("Utilities/Upload.php", {
            method: "POST",
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();  // 刷新页面，显示新头像
            })
            .catch(error => console.error("Upload failed:", error));
    });
</script>

</body>
</html>
