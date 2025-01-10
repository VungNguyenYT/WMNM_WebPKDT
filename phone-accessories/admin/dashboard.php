<?php

session_start();

// Kiểm tra nếu chưa đăng nhập hoặc không phải admin
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

<body
    style="font-family: Arial, sans-serif; background: linear-gradient(to right, #4facfe, #00f2fe); margin: 0; padding: 0;">

    <!-- Header -->
    <header
        style="background: #007bff; color: white; padding: 15px; text-align: center; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <h1 style="margin: 0; font-size: 28px;">Admin Dashboard</h1>
    </header>

    <!-- Navigation -->
    <nav style="text-align: center; margin: 20px 0;">
        <a href="manage-products.php"
            style="padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 5px; margin-right: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">Quản
            lý sản phẩm</a>
        <a href="manage-users.php"
            style="padding: 10px 20px; background: #17a2b8; color: white; text-decoration: none; border-radius: 5px; margin-right: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">Quản
            lý tài khoản</a>
        <a href="../logout.php"
            style="padding: 10px 20px; background: #dc3545; color: white; text-decoration: none; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">Đăng
            xuất</a>
    </nav>

    <!-- Main Content -->
    <main
        style="max-width: 1000px; margin: 20px auto; background: white; border-radius: 10px; padding: 20px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
        <h2 style="text-align: center; color: #343a40; margin-bottom: 20px;">Chào mừng,
            <?php echo $_SESSION['user']['fullname']; ?>!
        </h2>
        <p style="text-align: center; font-size: 18px; color: #555;">Hãy chọn một hành động để quản lý hệ thống.</p>

        <!-- Quick Actions -->
        <div style="display: flex; justify-content: space-around; margin-top: 30px;">
            <div
                style="text-align: center; background: #f8f9fa; padding: 20px; border-radius: 10px; width: 30%; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <h3 style="color: #28a745;">Quản lý sản phẩm</h3>
                <p style="color: #555;">Thêm, sửa, xóa sản phẩm trong hệ thống.</p>
                <a href="manage-products.php"
                    style="padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 5px;">Đi
                    đến</a>
            </div>
            <div
                style="text-align: center; background: #f8f9fa; padding: 20px; border-radius: 10px; width: 30%; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <h3 style="color: #17a2b8;">Quản lý tài khoản</h3>
                <p style="color: #555;">Quản lý thông tin người dùng.</p>
                <a href="manage-users.php"
                    style="padding: 10px 20px; background: #17a2b8; color: white; text-decoration: none; border-radius: 5px;">Đi
                    đến</a>
            </div>
            <div
                style="text-align: center; background: #f8f9fa; padding: 20px; border-radius: 10px; width: 30%; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <h3 style="color: #dc3545;">Đăng xuất</h3>
                <p style="color: #555;">Kết thúc phiên làm việc.</p>
                <a href="../logout.php"
                    style="padding: 10px 20px; background: #dc3545; color: white; text-decoration: none; border-radius: 5px;">Đăng
                    xuất</a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer style="background: #333; color: white; text-align: center; padding: 10px 0; margin-top: 20px;">
        <p>&copy; 2025 Phone Accessories. All rights reserved.</p>
    </footer>
</body>

</html>