<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: ../login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>

<body style="font-family: Arial, sans-serif; background: #f4f6f9; margin: 0; padding: 0;">

    <header style="background: #007bff; color: #fff; padding: 15px; text-align: center;">
        <h1>Admin Dashboard</h1>
    </header>

    <main
        style="max-width: 800px; margin: 20px auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
        <nav style="margin-bottom: 20px; text-align: center;">
            <a href="manage-products.php"
                style="margin: 0 10px; padding: 10px 20px; background: #28a745; color: #fff; text-decoration: none; border-radius: 5px;">Quản
                lý sản phẩm</a>
            <a href="manage-users.php"
                style="margin: 0 10px; padding: 10px 20px; background: #17a2b8; color: #fff; text-decoration: none; border-radius: 5px;">Quản
                lý tài khoản</a>
            <a href="../logout.php"
                style="margin: 0 10px; padding: 10px 20px; background: #dc3545; color: #fff; text-decoration: none; border-radius: 5px;">Đăng
                xuất</a>
        </nav>

        <h2 style="text-align: center;">Chào mừng đến với Admin Dashboard!</h2>
    </main>
</body>

</html>