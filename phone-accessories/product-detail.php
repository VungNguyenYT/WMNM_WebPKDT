<?php include 'includes/header.php'; ?>
<?php
// Kết nối đến cơ sở dữ liệu
$conn = new mysqli('localhost', 'root', '', 'mnm_pkdt');

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy ID sản phẩm từ URL
$id = $_GET['id'] ?? 0;

// Truy vấn sản phẩm theo ID
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Sản phẩm không tồn tại.");
}

// Lấy danh sách sản phẩm cùng danh mục
$category_id = $product['category_id'];
$sql_related = "SELECT * FROM products WHERE category_id = ? AND id != ? LIMIT 8"; // Lấy tối đa 8 sản phẩm cùng danh mục
$stmt_related = $conn->prepare($sql_related);
$stmt_related->bind_param("ii", $category_id, $id);
$stmt_related->execute();
$related_products = $stmt_related->get_result();

$stmt->close();
$stmt_related->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm</title>
</head>

<body style="font-family: Arial, sans-serif; background: #f8f9fa; margin: 0; padding: 0;">

    <!-- Header -->
    <!-- <header
        style="background: #007bff; color: #fff; padding: 15px 0; text-align: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
        <h1 style="font-size: 24px; margin: 0;">Chi tiết sản phẩm</h1>
    </header> -->

    <!-- Product Details -->
    <main
        style="padding: 30px; max-width: 800px; margin: 30px auto; background: #fff; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
        <div style="display: flex; gap: 20px; margin-bottom: 30px;">
            <!-- Product Image -->
            <div style="flex: 1;">
                <img src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>"
                    style="width: 100%; border-radius: 10px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
            </div>
            <!-- Product Info -->
            <div style="flex: 2; display: flex; flex-direction: column; justify-content: space-between;">
                <h2 style="font-size: 24px; color: #343a40; margin-bottom: 10px;"><?php echo $product['name']; ?></h2>
                <p style="font-size: 16px; color: #555; line-height: 1.5; margin-bottom: 20px;">
                    <?php echo $product['description']; ?>
                </p>
                <p style="font-size: 20px; font-weight: bold; color: #e63946; margin-bottom: 20px;">Giá:
                    <?php echo number_format($product['price']); ?> VND
                </p>
                <form action="cart.php" method="POST" style="display: flex; gap: 10px; align-items: center;">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <label for="quantity" style="font-size: 16px; color: #555;">Số lượng:</label>
                    <input type="number" name="quantity" value="1" min="1"
                        style="padding: 10px; width: 60px; border: 1px solid #ddd; border-radius: 5px;">
                    <button type="submit"
                        style="padding: 10px 20px; background: #28a745; color: #fff; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; transition: background 0.3s;">
                        Thêm vào giỏ hàng
                    </button>
                </form>
            </div>
        </div>

        <!-- Related Products -->
        <h3 style="font-size: 20px; color: #495057; margin-bottom: 20px;">Sản phẩm cùng danh mục</h3>
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
            <?php while ($related = $related_products->fetch_assoc()): ?>
                <div
                    style="background: #f8f9fa; padding: 15px; border: 1px solid #ddd; border-radius: 5px; text-align: center; transition: transform 0.3s, box-shadow 0.3s;">
                    <img src="images/<?php echo $related['image']; ?>" alt="<?php echo $related['name']; ?>"
                        style="width: 100%; height: auto; border-radius: 5px; margin-bottom: 10px;">
                    <h4 style="font-size: 18px; margin-bottom: 10px; color: #333;"><?php echo $related['name']; ?></h4>
                    <p style="font-size: 16px; color: #555; margin-bottom: 10px;">Giá:
                        <?php echo number_format($related['price']); ?> VND
                    </p>
                    <a href="product-detail.php?id=<?php echo $related['id']; ?>"
                        style="padding: 10px 20px; background: #007bff; color: #fff; text-decoration: none; border-radius: 5px; transition: background 0.3s;">Xem
                        chi tiết</a>
                </div>
            <?php endwhile; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer
        style="background: #333; color: #fff; text-align: center; padding: 15px 0; margin-top: 20px; font-size: 14px;">
        <p>&copy; 2025 Phone Accessories. All rights reserved.</p>
    </footer>

</body>

</html>