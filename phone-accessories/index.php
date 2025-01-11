<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone Accessories</title>
</head>

<body
    style="font-family: Arial, sans-serif; background: linear-gradient(to right, #f8f9fa, #e9ecef); margin: 0; padding: 0;">

    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <!-- Main content -->
    <main
        style="padding: 30px; max-width: 1200px; margin: 20px auto; background: #fff; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
        <h2 style="margin-bottom: 20px; font-size: 24px; color: #343a40;">Chào mừng đến với cửa hàng phụ kiện điện thoại
        </h2>

        <!-- Search form -->
        <form action="products.php" method="GET" style="margin-bottom: 30px; display: flex; align-items: center;">
            <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..."
                style="padding: 10px; width: 70%; font-size: 16px; border: 1px solid #ddd; border-radius: 5px; margin-right: 10px;">
            <button type="submit"
                style="padding: 10px 20px; background: #28a745; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; transition: background 0.3s;">
                Tìm kiếm
            </button>
        </form>

        <!-- Categories -->
        <h3 style="margin-bottom: 20px; font-size: 20px; color: #495057;">Danh mục sản phẩm</h3>
        <ul style="list-style: none; padding: 0; display: flex; flex-wrap: wrap; gap: 10px;">
            <li
                style="flex: 1 1 calc(20% - 10px); background: #f8f9fa; padding: 15px; text-align: center; border: 1px solid #ddd; border-radius: 5px; transition: transform 0.3s, box-shadow 0.3s;">
                <a href="products.php?category=1"
                    style="text-decoration: none; color: #007bff; font-size: 16px; font-weight: bold;">Ốp lưng</a>
            </li>
            <li
                style="flex: 1 1 calc(20% - 10px); background: #f8f9fa; padding: 15px; text-align: center; border: 1px solid #ddd; border-radius: 5px; transition: transform 0.3s, box-shadow 0.3s;">
                <a href="products.php?category=2"
                    style="text-decoration: none; color: #007bff; font-size: 16px; font-weight: bold;">Kính cường
                    lực</a>
            </li>
            <li
                style="flex: 1 1 calc(20% - 10px); background: #f8f9fa; padding: 15px; text-align: center; border: 1px solid #ddd; border-radius: 5px; transition: transform 0.3s, box-shadow 0.3s;">
                <a href="products.php?category=3"
                    style="text-decoration: none; color: #007bff; font-size: 16px; font-weight: bold;">Cáp sạc</a>
            </li>
            <li
                style="flex: 1 1 calc(20% - 10px); background: #f8f9fa; padding: 15px; text-align: center; border: 1px solid #ddd; border-radius: 5px; transition: transform 0.3s, box-shadow 0.3s;">
                <a href="products.php?category=4"
                    style="text-decoration: none; color: #007bff; font-size: 16px; font-weight: bold;">Pin dự phòng</a>
            </li>
            <li
                style="flex: 1 1 calc(20% - 10px); background: #f8f9fa; padding: 15px; text-align: center; border: 1px solid #ddd; border-radius: 5px; transition: transform 0.3s, box-shadow 0.3s;">
                <a href="products.php?category=5"
                    style="text-decoration: none; color: #007bff; font-size: 16px; font-weight: bold;">Tai nghe</a>
            </li>
        </ul>

        <!-- Products List -->
        <h3 style="margin-top: 40px; margin-bottom: 20px; font-size: 20px; color: #495057;">Tất cả sản phẩm</h3>
        <div style="display: flex; flex-wrap: wrap; gap: 20px;">
            <?php
            // Kết nối cơ sở dữ liệu
            $conn = new mysqli('localhost', 'root', '', 'mnm_pkdt');
            if ($conn->connect_error) {
                die("Kết nối thất bại: " . $conn->connect_error);
            }

            // Truy vấn lấy tất cả sản phẩm
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($product = $result->fetch_assoc()) {
                    echo "<div style='flex: 1 1 calc(25% - 20px); background: #f8f9fa; padding: 15px; text-align: center; border: 1px solid #ddd; border-radius: 5px; transition: transform 0.3s, box-shadow 0.3s;'>";
                    echo "<img src='images/{$product['image']}' alt='{$product['name']}' style='width: 100%; height: auto; margin-bottom: 10px; border-radius: 5px;'>";
                    echo "<h4 style='font-size: 18px; margin-bottom: 10px; color: #333;'>{$product['name']}</h4>";
                    echo "<p style='font-size: 16px; color: #555; margin-bottom: 10px;'>Giá: " . number_format($product['price']) . " VND</p>";
                    echo "<a href='product-detail.php?id={$product['id']}' style='display: inline-block; padding: 10px 20px; background: #007bff; color: #fff; text-decoration: none; border-radius: 5px; transition: background 0.3s;'>Xem chi tiết</a>";
                    echo "</div>";
                }
            } else {
                echo "<p>Không có sản phẩm nào!</p>";
            }

            $conn->close();
            ?>
        </div>
    </main>

    <!-- Footer -->

    <?php include 'includes/footer.php'; ?>

</body>

</html>