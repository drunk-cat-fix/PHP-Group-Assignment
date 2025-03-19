<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .register-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
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
        #profile-preview {
            margin-top: 10px;
            max-width: 100px;
            max-height: 100px;
            border-radius: 50%;
        }
    </style>
</head>
<body>

<div class="register-container">
    <h2>User Registration</h2>
    <form action="registration.php" method="post" enctype="multipart/form-data">
    <input type="text" id="name" placeholder="Full Name" required>
        <input type="text" id="username" placeholder="Username" required>
    <input type="email" id="email" placeholder="Email" required>
    <input type="password" id="password" placeholder="Password" required>

    <select id="role">
        <option value="">Select Role</option>
        <option value="vendor">Vendor</option>
        <option value="customer">Customer</option>
        <option value="staff">Staff</option>
    </select>

    <label for="profile">Upload Profile Picture</label>
    <input type="file" id="profile" accept=".jpeg, .png, .jpg, .bmp" onchange="previewProfile()">
    <img id="profile-preview" src="" alt="Profile Preview" style="display: none;">

    <button onclick="registerUser()" type="submit">Register</button>
    </form>
</div>

<script>
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

    function registerUser() {
        var name = document.getElementById("name").value;
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;
        var role = document.getElementById("role").value;
        var profile = document.getElementById("profile").files[0];

        if (name === "" || email === "" || password === "" || role === "" || !profile) {
            alert("Please fill in all fields and upload a profile picture.");
            return;
        }

        if (!validateEmail(email)) {
            alert("Invalid email format.");
            return;
        }

        alert("Registration successful! (In a real app, this data would be sent to the backend.)");

        // Here, you can send the data to a backend using AJAX, Fetch API, or form submission
    }

    function validateEmail(email) {
        var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
</script>

</body>
</html>

