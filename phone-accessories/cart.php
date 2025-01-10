<?php include 'includes/header.php'; ?>
<?php
session_start();

// Kiểm tra nếu giỏ hàng chưa tồn tại, khởi tạo giỏ hàng trống
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = []; // Khởi tạo giỏ hàng trống
}

// Kiểm tra nếu giỏ hàng trống
if (empty($_SESSION['cart'])) {
    echo "<h2 style='text-align: center; margin-top: 20px;'>Giỏ hàng của bạn đang trống.</h2>";
    return;
}

// Lấy dữ liệu giỏ hàng từ session
$cart = $_SESSION['cart'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng của bạn</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        header {
            background: #007bff;
            color: #fff;
            padding: 15px 0;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        main {
            max-width: 1200px;
            margin: 20px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item img {
            width: 80px;
            height: auto;
            border-radius: 5px;
        }

        .cart-item-info {
            flex: 1;
            margin-left: 20px;
        }

        .cart-item h4 {
            margin: 0 0 5px;
            font-size: 18px;
        }

        .cart-item p {
            margin: 5px 0;
            color: #555;
        }

        .cart-item .quantity {
            display: flex;
            align-items: center;
        }

        .cart-item .quantity input {
            width: 60px;
            padding: 5px;
            text-align: center;
            margin-left: 10px;
        }

        .cart-item .remove {
            color: #e63946;
            text-decoration: none;
            font-size: 16px;
            margin-left: 20px;
        }

        .cart-item .remove:hover {
            text-decoration: underline;
        }

        footer {
            background: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header>
        <h1>Giỏ hàng của bạn</h1>
    </header>

    <!-- Main content -->
    <main>
        <?php foreach ($cart as $item): ?>
            <div class="cart-item">
                <!-- Hình ảnh sản phẩm -->
                <img src="images/<?php echo htmlspecialchars($item['image']); ?>"
                    alt="<?php echo htmlspecialchars($item['name']); ?>">

                <!-- Thông tin sản phẩm -->
                <div class="cart-item-info">
                    <h4><?php echo htmlspecialchars($item['name']); ?></h4>
                    <p>Giá: <?php echo number_format($item['price']); ?> VND</p>
                    <div class="quantity">
                        Số lượng:
                        <input type="number" value="<?php echo $item['quantity']; ?>" min="1">
                    </div>
                </div>

                <!-- Nút xóa sản phẩm -->
                <a href="remove-from-cart.php?id=<?php echo $item['id']; ?>" class="remove">Xóa</a>
            </div>
        <?php endforeach; ?>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Phone Accessories. All rights reserved.</p>
    </footer>

</body>

</html>