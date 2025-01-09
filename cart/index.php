<?php
session_start();
<link rel="stylesheet" href="assets/css/style.css">
// Giả sử giỏ hàng là một mảng trong session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Hàm tính tổng giá trị giỏ hàng
function getTotalPrice($cart) {
    $total = 0;
    foreach ($cart as $product_id => $details) {
        $total += $details['price'] * $details['quantity'];
    }
    return $total;
}

// Xử lý xóa sản phẩm khỏi giỏ hàng
if (isset($_GET['remove'])) {
    $product_id = $_GET['remove'];
    unset($_SESSION['cart'][$product_id]);
    header('Location: index.php');
    exit();
}

// Xử lý cập nhật số lượng sản phẩm
if (isset($_POST['update'])) {
    foreach ($_POST['quantity'] as $product_id => $quantity) {
        $_SESSION['cart'][$product_id]['quantity'] = $quantity;
    }
    header('Location: index.php');
    exit();
}

// Dữ liệu giả cho sản phẩm
$products = [
    1 => ["name" => "Ốp lưng iPhone", "price" => 200000, "image" => "assets/images/product1.jpg"],
    2 => ["name" => "Sạc nhanh", "price" => 150000, "image" => "assets/images/product2.jpg"]
];

// Nếu có sản phẩm trong giỏ hàng, lấy chi tiết
$cart = $_SESSION['cart'];
?>

<?php include('../includes/header.php'); ?>

<div class="container">
    <h1>Giỏ hàng của bạn</h1>
    
    <?php if (empty($cart)): ?>
        <p>Giỏ hàng của bạn hiện đang trống.</p>
    <?php else: ?>
        <form action="index.php" method="post">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng cộng</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $product_id => $details): ?>
                        <tr>
                            <td>
                                <img src="<?php echo $products[$product_id]['image']; ?>" alt="<?php echo $products[$product_id]['name']; ?>" class="cart-img">
                                <p><?php echo $products[$product_id]['name']; ?></p>
                            </td>
                            <td><?php echo number_format($products[$product_id]['price'], 0, ',', '.') . ' VND'; ?></td>
                            <td>
                                <input type="number" name="quantity[<?php echo $product_id; ?>]" value="<?php echo $details['quantity']; ?>" min="1" max="10">
                            </td>
                            <td><?php echo number_format($products[$product_id]['price'] * $details['quantity'], 0, ',', '.') . ' VND'; ?></td>
                            <td><a href="?remove=<?php echo $product_id; ?>">Xóa</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="cart-summary">
                <p><strong>Tổng giá trị giỏ hàng: </strong><?php echo number_format(getTotalPrice($cart), 0, ',', '.') . ' VND'; ?></p>
                <button type="submit" name="update">Cập nhật giỏ hàng</button>
                <button type="button" onclick="window.location.href='checkout.php'">Tiến hành thanh toán</button>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php include('../includes/footer.php'); ?>
