<?php
session_start();
include 'includes/db.php'; // Kết nối cơ sở dữ liệu

// Kiểm tra giỏ hàng
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p style='text-align: center; color: red;'>Giỏ hàng trống. <a href='index.php'>Quay lại mua sắm</a></p>";
    exit;
}

$cart = $_SESSION['cart'];
$total_price = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        form input,
        form textarea,
        form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        form button {
            padding: 10px 20px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        form button:hover {
            background: #218838;
        }
    </style>
</head>

<body>

    <header>
        <h1>Thanh toán</h1>
    </header>

    <main
        style="max-width: 800px; margin: 20px auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
        <h2>Thông tin giỏ hàng</h2>
        <table>
            <thead>
                <tr style="background: #f8f9fa;">
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Tổng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $productID => $item): ?>
                    <tr>
                        <td><img src="uploads/<?= htmlspecialchars($item['image']) ?>" alt="Hình ảnh"
                                style="width: 100px; height: auto;"></td>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($item['price'], 0, ',', '.') ?> VND</td>
                        <td><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> VND</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right; font-weight: bold;">Tổng cộng:</td>
                    <td><?= number_format($total_price, 0, ',', '.') ?> VND</td>
                </tr>
            </tfoot>
        </table>

        <h2>Thông tin khách hàng</h2>
        <form action="checkout_process.php" method="POST">
            <input type="text" name="full_name" placeholder="Họ và tên" required>
            <input type="text" name="phone" placeholder="Số điện thoại" required>
            <textarea name="address" placeholder="Địa chỉ" required></textarea>
            <select name="payment_method" required>
                <option value="COD">Thanh toán khi nhận hàng (COD)</option>
                <option value="BANK">Thanh toán qua thẻ ngân hàng</option>
            </select>
            <button type="submit">Đặt hàng</button>
        </form>
    </main>

</body>

</html>