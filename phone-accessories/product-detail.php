<?php include 'includes/header.php'; ?>

<main>
    <?php
    $id = $_GET['id'] ?? 0;
    $sql = "SELECT * FROM products WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result);
    ?>

    <h2><?php echo $product['name']; ?></h2>
    <img src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
    <p><?php echo $product['description']; ?></p>
    <p>Giá: <?php echo $product['price']; ?> VND</p>
    <form action="cart.php" method="POST">
        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
        <label for="quantity">Số lượng:</label>
        <input type="number" name="quantity" value="1" min="1">
        <button type="submit">Thêm vào giỏ hàng</button>
    </form>
</main>

<?php include 'includes/footer.php'; ?>