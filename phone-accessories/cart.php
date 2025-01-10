<?php
session_start();
include 'includes/db.php'; // Kết nối cơ sở dữ liệu
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
        <?php
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])):
            $cart = $_SESSION['cart'];
            $total = 0;
            ?>
            <table border="1" style="width: 100%; border-collapse: collapse; text-align: center;">
                <thead style="background: #f8f9fa;">
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                        <th>Thao tác</th>
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
                            $total += $subtotal;
                            ?>
                            <tr>
                                <td><img src="uploads/<?= htmlspecialchars($product['image']) ?>" alt="Hình ảnh"
                                        style="width: 100px; height: auto; border-radius: 5px;"></td>
                                <td><?= htmlspecialchars($product['name']) ?></td>
                                <td><?= number_format($product['price'], 0, ',', '.') ?> VND</td>
                                <td><?= $quantity ?></td>
                                <td><?= number_format($subtotal, 0, ',', '.') ?> VND</td>
                                <td>
                                    <form action="update_cart.php" method="post" style="display: inline;">
                                        <input type="hidden" name="product_id" value="<?= $productID ?>">
                                        <button type="submit" name="action" value="delete"
                                            style="padding: 5px 10px; background-color: #dc3545; color: white; border: none; border-radius: 3px;">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }
                    endforeach;
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align: right; font-weight: bold;">Tổng cộng:</td>
                        <td colspan="2"><?= number_format($total, 0, ',', '.') ?> VND</td>
                    </tr>
                </tfoot>
            </table>
            <div style="text-align: right; margin-top: 20px;">
                <a href="checkout.php"
                    style="padding: 10px 20px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px; font-size: 16px;">
                    Thanh toán
                </a>
            </div>
        <?php else: ?>
            <p style="text-align: center; font-weight: bold; color: red;">Giỏ hàng hiện đang trống!</p>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer style="background: #333; color: white; text-align: center; padding: 10px 0; margin-top: 20px;">
        <p>&copy; 2025 Phone Accessories. All rights reserved.</p>
    </footer>
</body>

</html>