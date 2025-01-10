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

// Thêm sản phẩm
if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Xử lý upload hình ảnh
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $sql = "INSERT INTO products (name, price, description, image) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sdss', $name, $price, $description, $image);

        if ($stmt->execute()) {
            $message = "Sản phẩm đã được thêm thành công!";
        } else {
            $message = "Lỗi khi thêm sản phẩm: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "Lỗi khi tải lên hình ảnh!";
    }
}

// Xóa sản phẩm
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        $message = "Sản phẩm đã được xóa thành công!";
    } else {
        $message = "Lỗi khi xóa sản phẩm: " . $stmt->error;
    }

    $stmt->close();
}

// Lấy danh sách sản phẩm
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
</head>

<body
    style="font-family: Arial, sans-serif; background: linear-gradient(to right, #4facfe, #00f2fe); margin: 0; padding: 0;">

    <!-- Header -->
    <header
        style="background: #007bff; color: white; padding: 15px; text-align: center; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <h1 style="margin: 0; font-size: 28px;">Quản lý sản phẩm</h1>
    </header>

    <!-- Message -->
    <?php if (!empty($message)): ?>
        <p style="text-align: center; color: green; font-weight: bold;"><?= $message ?></p>
    <?php endif; ?>

    <!-- Form Thêm Sản Phẩm -->
    <main
        style="max-width: 1000px; margin: 20px auto; background: white; border-radius: 10px; padding: 20px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
        <h2 style="text-align: center; color: #343a40; margin-bottom: 20px;">Thêm sản phẩm mới</h2>
        <form method="POST" action="" enctype="multipart/form-data"
            style="display: flex; flex-direction: column; gap: 15px; max-width: 600px; margin: auto;">
            <input type="text" name="name" placeholder="Tên sản phẩm" required
                style="padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
            <input type="number" name="price" placeholder="Giá sản phẩm (VND)" required
                style="padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
            <textarea name="description" placeholder="Mô tả sản phẩm" rows="5"
                style="padding: 10px; border-radius: 5px; border: 1px solid #ccc;"></textarea>
            <input type="file" name="image" required style="padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
            <button type="submit" name="add_product"
                style="padding: 10px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;">Thêm
                sản phẩm</button>
        </form>
    </main>

    <!-- Danh sách sản phẩm -->
    <main
        style="max-width: 1000px; margin: 20px auto; background: white; border-radius: 10px; padding: 20px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
        <h2 style="text-align: center; color: #343a40; margin-bottom: 20px;">Danh sách sản phẩm</h2>
        <table border="1" style="width: 100%; border-collapse: collapse; text-align: center;">
            <thead style="background: #f8f9fa;">
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá (VND)</th>
                    <th>Mô tả</th>
                    <th>Hình ảnh</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= number_format($row['price']) ?></td>
                        <td><?= htmlspecialchars($row['description']) ?></td>
                        <td>
                            <?php if (!empty($row['image'])): ?>
                                <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="Hình ảnh"
                                    style="width: 100px; height: auto; border-radius: 5px;">
                            <?php else: ?>
                                <span>Không có hình ảnh</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit-product.php?id=<?= $row['id'] ?>"
                                style="padding: 5px 10px; background: #ffc107; color: white; text-decoration: none; border-radius: 3px; margin-right: 5px;">Sửa</a>
                            <a href="manage-products.php?delete=<?= $row['id'] ?>"
                                style="padding: 5px 10px; background: #dc3545; color: white; text-decoration: none; border-radius: 3px;"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>

    <!-- Footer -->
    <footer style="background: #333; color: white; text-align: center; padding: 10px 0; margin-top: 20px;">
        <p>&copy; 2025 Phone Accessories. All rights reserved.</p>
    </footer>
</body>

</html>