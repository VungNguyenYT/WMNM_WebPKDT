<?php include 'includes/header.php'; ?>
<?php

session_start();
include 'includes/db.php'; // Kết nối cơ sở dữ liệu

// Xử lý thêm sản phẩm vào giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productID = $_POST['product_id'] ?? null;
    $quantity = $_POST['quantity'] ?? 1;

    if ($productID && $quantity > 0) {
        // Lấy thông tin sản phẩm từ CSDL
        $stmt = $conn->prepare("SELECT id, name, price, image FROM products WHERE id = ?");
        $stmt->bind_param('i', $productID);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if ($product) {
            // Thêm sản phẩm vào session giỏ hàng
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            if (isset($_SESSION['cart'][$productID])) {
                $_SESSION['cart'][$productID]['quantity'] += $quantity;
            } else {
                $_SESSION['cart'][$productID] = [
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'image' => $product['image'],
                    'quantity' => $quantity
                ];
            }
        }
    }
}

// Hiển thị giỏ hàng
$cart = $_SESSION['cart'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
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
            margin: 20px 0;
        }

        table th,
        table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .checkout-btn {
            display: inline-block;
            padding: 10px 20px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>

<body>

    <header>
        <h1>Giỏ hàng của bạn</h1>
    </header>

    <main
        style="max-width: 800px; margin: 20px auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
        <?php if (empty($cart)): ?>
            <p style="text-align: center; color: red;">Giỏ hàng trống. <a href="index.php">Quay lại mua sắm</a></p>
        <?php else: ?>
            <table>
                <thead>
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
                    <?php $total_price = 0; ?>
                    <?php foreach ($cart as $productID => $item): ?>
                        <?php $subtotal = $item['price'] * $item['quantity']; ?>
                        <?php $total_price += $subtotal; ?>
                        <tr>
                            <td><img src="uploads/<?= htmlspecialchars($item['image']) ?>" alt="Hình ảnh"
                                    style="width: 100px; height: auto;"></td>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td><?= number_format($item['price'], 0, ',', '.') ?> VND</td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= number_format($subtotal, 0, ',', '.') ?> VND</td>
                            <td>
                                <form action="update_cart.php" method="post" style="display: inline;">
                                    <input type="hidden" name="product_id" value="<?= $productID ?>">
                                    <button type="submit" name="action" value="delete"
                                        style="background: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 5px;">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align: right; font-weight: bold;">Tổng cộng:</td>
                        <td colspan="2"><?= number_format($total_price, 0, ',', '.') ?> VND</td>
                    </tr>
                </tfoot>
            </table>
            <div style="text-align: right;">
                <a href="checkout.php" class="checkout-btn">Thanh toán</a>
            </div>
        <?php endif; ?>
    </main>

</body>

</html>