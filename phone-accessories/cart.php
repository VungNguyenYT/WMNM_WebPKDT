<?php include 'includes/header.php'; ?>

<main>
    <h2>Giỏ hàng của bạn</h2>
    <?php
    // Lấy thông tin giỏ hàng từ session
    session_start();
    $cart = $_SESSION['cart'] ?? [];

    foreach ($cart as $item) {
        echo "<div class='cart-item'>";
        echo "<h3>{$item['name']}</h3>";
        echo "<p>Số lượng: {$item['quantity']}</p>";
        echo "<p>Giá: " . $item['price'] * $item['quantity'] . " VND</p>";
        echo "<a href='remove-from-cart.php?id={$item['id']}'>Xóa</a>";
        echo "</div>";
    }
    ?>
</main>

<?php include 'includes/footer.php'; ?>