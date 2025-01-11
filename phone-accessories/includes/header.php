<?php
session_start(); // Khởi động session để kiểm tra trạng thái đăng nhập
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone Accessories</title>
    <style>
        .header {
            background: #007bff;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
        }

        .header a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <header class="header">
        <div>
            <h1>Phone Accessories</h1>
        </div>
        <nav>
            <a href="index.php">Trang chủ</a>
            <a href="products.php">Sản phẩm</a>
            <a href="cart.php">Giỏ hàng</a>
            <?php if (isset($_SESSION['user'])): ?>
                <a href="logout.php">Đăng xuất</a>
            <?php else: ?>
                <a href="login.php">Đăng nhập</a>
            <?php endif; ?>
        </nav>
    </header>
</body>

</html>