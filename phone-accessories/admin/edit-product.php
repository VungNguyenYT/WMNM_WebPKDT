<?php
session_start();

// Kiểm tra nếu chưa đăng nhập hoặc không phải admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'mnm_pkdt');

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra nếu có ID sản phẩm được gửi qua
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Lấy thông tin sản phẩm từ CSDL
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if (!$product) {
        die("Sản phẩm không tồn tại!");
    }
} else {
    header('Location: manage-products.php');
    exit();
}

// Xử lý cập nhật thông tin sản phẩm
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Xử lý cập nhật hình ảnh nếu có
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target = "uploads/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    } else {
        $image = $product['image']; // Giữ nguyên hình ảnh cũ nếu không chọn hình mới
    }

    $sql = "UPDATE products SET name = ?, price = ?, description = ?, image = ?, updated_at = NOW() WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sdssi', $name, $price, $description, $image, $id);

    if ($stmt->execute()) {
        $message = "Thông tin sản phẩm đã được cập nhật!";
        header('Location: manage-products.php');
        exit();
    } else {
        $message = "Lỗi khi cập nhật sản phẩm: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa sản phẩm</title>
</head>

<body
    style="font-family: Arial, sans-serif; background: linear-gradient(to right, #4facfe, #00f2fe); margin: 0; padding: 0;">

    <!-- Header -->
    <header
        style="background: #007bff; color: white; padding: 15px; text-align: center; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <h1 style="margin: 0; font-size: 28px;">Chỉnh sửa sản phẩm</h1>
    </header>

    <!-- Message -->
    <?php if (!empty($message)): ?>
        <p style="text-align: center; color: green; font-weight: bold;"><?= $message ?></p>
    <?php endif; ?>

    <!-- Form Chỉnh Sửa Sản Phẩm -->
    <main
        style="max-width: 600px; margin: 20px auto; background: white; border-radius: 10px; padding: 20px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
        <form method="POST" action="" enctype="multipart/form-data"
            style="display: flex; flex-direction: column; gap: 15px;">
            <label for="name" style="font-weight: bold;">Tên sản phẩm:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required
                style="padding: 10px; border-radius: 5px; border: 1px solid #ccc;">

            <label for="price" style="font-weight: bold;">Giá sản phẩm (VND):</label>
            <input type="number" name="price" value="<?= htmlspecialchars($product['price']) ?>" required
                style="padding: 10px; border-radius: 5px; border: 1px solid #ccc;">

            <label for="description" style="font-weight: bold;">Mô tả sản phẩm:</label>
            <textarea name="description" rows="5"
                style="padding: 10px; border-radius: 5px; border: 1px solid #ccc;"><?= htmlspecialchars($product['description']) ?></textarea>

            <label for="image" style="font-weight: bold;">Hình ảnh sản phẩm:</label>
            <input type="file" name="image" style="padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
            <p>Hình hiện tại:</p>
            <img src="uploads/<?= htmlspecialchars($product['image']) ?>" alt="Hình ảnh sản phẩm"
                style="width: 100px; height: auto; border-radius: 5px;">

            <button type="submit"
                style="padding: 10px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;">Cập
                nhật</button>
        </form>
    </main>

    <!-- Footer -->
    <footer style="background: #333; color: white; text-align: center; padding: 10px 0; margin-top: 20px;">
        <p>&copy; 2025 Phone Accessories. All rights reserved.</p>
    </footer>
</body>

</html>