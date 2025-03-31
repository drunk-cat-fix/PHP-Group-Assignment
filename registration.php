<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
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

        .register-container {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            width: 350px;
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

        #profile-preview {
            margin-top: 10px;
            max-width: 80px;
            max-height: 80px;
            border-radius: 50%;
            display: none;
            border: 2px solid #764ba2;
        }
    </style>
</head>
<body>

<div class="register-container">
    <h2>User Registration</h2>
    <form action="service/AdminRegistration.php" method="post" enctype="multipart/form-data">
<!--        <input type="text" id="name" placeholder="Full Name" required>-->
        <input type="text" id="username" name="username" placeholder="Username" required>
        <input type="email" id="email" name="email" placeholder="Email" required>
        <input type="password" id="password" name="password" placeholder="Password" required>

        <select id="role" name="role">
            <option value="">Select Role</option>
            <option value="Admin">Admin</option>
            <option value="Vendor">Vendor</option>
            <option value="Customer">Customer</option>
            <option value="Staff">Staff</option>
        </select>

        <label for="profile">Upload Profile Picture</label>
        <input type="file" id="profile" name="profile" accept=".jpeg, .png, .jpg, .bmp" onchange="previewProfile()">
        <img id="profile-preview" src="" alt="Profile Preview">

        <button type="submit" onclick="return validateForm()">Register</button>
    </form>
</div>

<script>
    /* 🎨 头像预览功能 */
    function previewProfile() {
        var file = document.getElementById("profile").files[0];
        var reader = new FileReader();

        reader.onload = function (e) {
            var img = document.getElementById("profile-preview");
            img.src = e.target.result;
            img.style.display = "block";
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    }

    /* 🚀 表单验证 */
    function validateForm() {
        var name = document.getElementById("name").value;
        var username = document.getElementById("username").value;
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;
        var role = document.getElementById("role").value;
        var profile = document.getElementById("profile").files[0];

        if (name === "" || username === "" || email === "" || password === "" || role === "") {
            alert("❗ Please fill in all fields.");
            return false;
        }

        if (!validateEmail(email)) {
            alert("❗ Invalid email format.");
            return false;
        }

        if (!profile) {
            alert("📸 Please upload a profile picture.");
            return false;
        }

        alert("✅ Registration successful!");
        return true; // 在真实应用中，数据将发送到服务器
    }

    /* 📧 验证 Email 格式 */
    function validateEmail(email) {
        var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
</script>

</body>
</html>
