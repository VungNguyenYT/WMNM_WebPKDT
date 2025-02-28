<?php
session_start();
include 'includes/db.php'; // Kết nối cơ sở dữ liệu

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $fullName = $_POST['full_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $paymentMethod = $_POST['payment_method'];
    $user_id = $_SESSION['user']['id']; // Lấy ID người dùng từ session
    $cart = $_SESSION['cart'];
    $total_price = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

    // Lưu thông tin đơn hàng vào bảng customer_orders
    $stmt = $conn->prepare("INSERT INTO customer_orders (user_id, full_name, phone, address, payment_method, total_price) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('issssd', $user_id, $fullName, $phone, $address, $paymentMethod, $total_price);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    // Lưu chi tiết đơn hàng vào bảng customer_order_items
    foreach ($cart as $productID => $item) {
        $subtotal = $item['price'] * $item['quantity'];
        $stmt = $conn->prepare("INSERT INTO customer_order_items (order_id, product_id, quantity, price, subtotal) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('iiidd', $order_id, $productID, $item['quantity'], $item['price'], $subtotal);
        $stmt->execute();
    }

    // Xóa giỏ hàng sau khi đặt hàng thành công
    unset($_SESSION['cart']);

    // Chuyển hướng đến trang xác nhận
    header('Location: success.php');
    exit();
}
?>