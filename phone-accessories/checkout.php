<?php
session_start();
include 'includes/db.php'; // Kết nối cơ sở dữ liệu

// Kiểm tra nếu giỏ hàng trống
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p style='text-align: center; color: red;'>Giỏ hàng trống. <a href='index.php'>Quay lại mua sắm</a></p>";
    exit;
}

$cart = $_SESSION['cart'];
$total_price = 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
</head>

<body style="font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0;">

    <!-- Header -->
    <header style="background: #007bff; color: white; padding: 15px; text-align: center;">
        <h1>Thanh toán</h1>
    </header>

    <!-- Danh sách sản phẩm trong giỏ hàng -->
    <main
        style="max-width: 800px; margin: 20px auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
        <h2 style="text-align: center;">Danh sách sản phẩm</h2>
        <table border="1" style="width: 100%; border-collapse: collapse; margin-bottom: 20px; text-align: center;">
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
                <?php
                foreach ($cart as $productID => $quantity):
                    $stmt = $conn->prepare("SELECT name, price, image FROM products WHERE id = ?");
                    $stmt->bind_param('i', $productID);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $product = $result->fetch_assoc();

                    if ($product) {
                        $subtotal = $product['price'] * $quantity;
                        $total_price += $subtotal;
                        ?>
                        <tr>
                            <td><img src="uploads/<?= htmlspecialchars($product['image']) ?>" alt="Hình ảnh"
                                    style="width: 100px; height: auto; border-radius: 5px;"></td>
                            <td><?= htmlspecialchars($product['name']) ?></td>
                            <td><?= $quantity ?></td>
                            <td><?= number_format($product['price'], 0, ',', '.') ?> VND</td>
                            <td><?= number_format($subtotal, 0, ',', '.') ?> VND</td>
                        </tr>
                        <?php
                    }
                endforeach;
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right; font-weight: bold;">Tổng cộng:</td>
                    <td><?= number_format($total_price, 0, ',', '.') ?> VND</td>
                </tr>
            </tfoot>
        </table>

        <!-- Form điền thông tin thanh toán -->
        <h2 style="text-align: center;">Thông tin thanh toán</h2>
        <form action="checkout_process.php" method="POST">
            <div style="margin-bottom: 15px;">
                <label for="full_name" style="display: block; font-weight: bold;">Họ và tên</label>
                <input type="text" name="full_name" id="full_name" required
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label for="phone" style="display: block; font-weight: bold;">Số điện thoại</label>
                <input type="text" name="phone" id="phone" required
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label for="address" style="display: block; font-weight: bold;">Địa chỉ</label>
                <textarea name="address" id="address" required
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;"></textarea>
            </div>
            <div style="margin-bottom: 15px;">
                <label for="payment_method" style="display: block; font-weight: bold;">Phương thức thanh toán</label>
                <select name="payment_method" id="payment_method" required
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    <option value="COD">Thanh toán khi nhận hàng (COD)</option>
                    <option value="BANK">Thanh toán qua thẻ ngân hàng</option>
                </select>
            </div>
            <button type="submit"
                style="width: 100%; padding: 10px; background: #28a745; color: white; border: none; border-radius: 5px; font-size: 16px;">Đặt
                hàng</button>
        </form>
    </main>

    <!-- Footer -->
    <footer style="background: #333; color: white; text-align: center; padding: 10px 0; margin-top: 20px;">
        <p>&copy; 2025 Phone Accessories. All rights reserved.</p>
    </footer>
</body>

</html>