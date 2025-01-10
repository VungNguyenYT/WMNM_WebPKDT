<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
</head>

<body style="font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0;">

    <!-- Header -->
    <header
        style="background: #007bff; color: white; padding: 15px; text-align: center; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <h1 style="margin: 0; font-size: 28px;">Giỏ hàng của bạn</h1>
    </header>

    <!-- Danh sách sản phẩm trong giỏ hàng -->
    <main
        style="max-width: 1000px; margin: 20px auto; background: white; border-radius: 10px; padding: 20px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
        <?php if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])): ?>
            <table border="1" style="width: 100%; border-collapse: collapse; text-align: center;">
                <thead style="background: #f8f9fa;">
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng tiền</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                        <?php if (is_array($item)): ?>
                            <tr>
                                <td><img src="uploads/<?= htmlspecialchars($item['image']) ?>" alt="Hình ảnh"
                                        style="width: 100px; height: auto; border-radius: 5px;"></td>
                                <td><?= htmlspecialchars($item['name']) ?></td>
                                <td><?= number_format($item['price']) ?> VND</td>
                                <td><?= $item['quantity'] ?></td>
                                <td><?= number_format($item['price'] * $item['quantity']) ?> VND</td>
                                <td>
                                    <a href="remove-from-cart.php?id=<?= $id ?>"
                                        style="padding: 5px 10px; background: #dc3545; color: white; text-decoration: none; border-radius: 3px;">Xóa</a>
                                </td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="color: red; text-align: center;">Dữ liệu sản phẩm không hợp lệ!</td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align: center; color: red; font-weight: bold;">Giỏ hàng hiện đang trống!</p>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer style="background: #333; color: white; text-align: center; padding: 10px 0; margin-top: 20px;">
        <p>&copy; 2025 Phone Accessories. All rights reserved.</p>
    </footer>
</body>

</html>