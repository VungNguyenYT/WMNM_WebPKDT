<?php include 'includes/header.php'; ?>

<main>
    <h2>Sản phẩm</h2>
    <?php
    // Giả sử kết nối CSDL đã được thực hiện
    $category = $_GET['category'] ?? null;
    $search = $_GET['search'] ?? null;

    // Câu lệnh SQL lấy sản phẩm
    $sql = "SELECT * FROM products WHERE 1";
    if ($category) {
        $sql .= " AND category_id = $category";
    }
    if ($search) {
        $sql .= " AND name LIKE '%$search%'";
    }

    // Thực thi câu lệnh SQL (giả sử $conn là kết nối CSDL)
    $result = mysqli_query($conn, $sql);
    while ($product = mysqli_fetch_assoc($result)) {
        echo "<div class='product'>";
        echo "<img src='images/{$product['image']}' alt='{$product['name']}'>";
        echo "<h3>{$product['name']}</h3>";
        echo "<p>Giá: {$product['price']} VND</p>";
        echo "<a href='product-detail.php?id={$product['id']}'>Xem chi tiết</a>";
        echo "</div>";
    }
    ?>
</main>

<?php include 'includes/footer.php'; ?>