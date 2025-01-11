<?php
session_start(); // Khởi động session

// Hủy toàn bộ session
session_unset();
session_destroy();

// Chuyển hướng về trang đăng nhập
header('Location: login.php');
exit();
?>