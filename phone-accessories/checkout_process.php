<?php
session_start();
include 'includes/db.php'; // Kết nối CSDL

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $fullName = $_POST['full_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $paymentMethod = $_POST['payment_method'];
    $user_id = $_SESSION['user']['id'];
    $cart = $_SESSION['cart'];
    $total_price = 0;

    // Tính tổng giá trị đơn hàng
    foreach ($cart as $productID => $quantity) {
        $stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
        $stmt->bind_param('i', $productID);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $total_price += $product['price'] * $quantity;
    }

    // Lưu đơn hàng vào bảng customer_orders
    $stmt = $conn->prepare("INSERT INTO customer_orders (user_id, full_name, phone, address, payment_method, total_price) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('issssd', $user_id, $fullName, $phone, $address, $paymentMethod, $total_price);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    // Lưu chi tiết đơn hàng vào bảng customer_order_items
    foreach ($cart as $productID => $quantity) {
        $stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
        $stmt->bind_param('i', $productID);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $price = $product['price'];
        $subtotal = $price * $quantity;

        $stmt = $conn->prepare("INSERT INTO customer_order_items (order_id, product_id, quantity, price, subtotal) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('iiidd', $order_id, $productID, $quantity, $price, $subtotal);
        $stmt->execute();
    }

    // Xóa giỏ hàng
    unset($_SESSION['cart']);

    // Chuyển hướng đến trang thành công
    header('Location: success.php');
    exit();
}
?>