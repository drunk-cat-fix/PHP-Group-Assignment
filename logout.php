<?php
session_start();
session_destroy(); // Optional: destroy entire session
header("Location: login.php"); // Redirect to login page (or any other page)
exit();
