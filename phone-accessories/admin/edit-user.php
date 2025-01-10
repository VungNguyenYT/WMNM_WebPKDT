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

// Kiểm tra nếu có ID người dùng được gửi qua
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Lấy thông tin người dùng từ CSDL
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        die("Người dùng không tồn tại!");
    }
} else {
    header('Location: manage-users.php');
    exit();
}

// Xử lý cập nhật thông tin người dùng
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    // Kiểm tra nếu có cập nhật mật khẩu
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE users SET fullname = ?, username = ?, password = ?, phone = ?, role = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssi', $fullname, $username, $password, $phone, $role, $id);
    } else {
        $sql = "UPDATE users SET fullname = ?, username = ?, phone = ?, role = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssi', $fullname, $username, $phone, $role, $id);
    }

    if ($stmt->execute()) {
        $message = "Thông tin người dùng đã được cập nhật!";
        header('Location: manage-users.php');
        exit();
    } else {
        $message = "Lỗi khi cập nhật thông tin: " . $stmt->error;
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
    <title>Chỉnh sửa thông tin người dùng</title>
</head>

<body
    style="font-family: Arial, sans-serif; background: linear-gradient(to right, #4facfe, #00f2fe); margin: 0; padding: 0;">

    <!-- Header -->
    <header
        style="background: #007bff; color: white; padding: 15px; text-align: center; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <h1 style="margin: 0; font-size: 28px;">Chỉnh sửa thông tin người dùng</h1>
    </header>

    <!-- Message -->
    <?php if (!empty($message)): ?>
        <p style="text-align: center; color: green; font-weight: bold;"><?= $message ?></p>
    <?php endif; ?>

    <!-- Form Chỉnh Sửa Người Dùng -->
    <main
        style="max-width: 600px; margin: 20px auto; background: white; border-radius: 10px; padding: 20px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
        <form method="POST" action="" style="display: flex; flex-direction: column; gap: 15px;">
            <label for="fullname" style="font-weight: bold;">Họ và tên:</label>
            <input type="text" name="fullname" value="<?= htmlspecialchars($user['fullname']) ?>" required
                style="padding: 10px; border-radius: 5px; border: 1px solid #ccc;">

            <label for="username" style="font-weight: bold;">Tên đăng nhập:</label>
            <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required
                style="padding: 10px; border-radius: 5px; border: 1px solid #ccc;">

            <label for="phone" style="font-weight: bold;">Số điện thoại:</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required
                style="padding: 10px; border-radius: 5px; border: 1px solid #ccc;">

            <label for="password" style="font-weight: bold;">Mật khẩu mới (nếu muốn đổi):</label>
            <input type="password" name="password" placeholder="Để trống nếu không muốn đổi"
                style="padding: 10px; border-radius: 5px; border: 1px solid #ccc;">

            <label for="role" style="font-weight: bold;">Vai trò:</label>
            <select name="role" required style="padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>Người dùng</option>
                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Quản trị viên</option>
            </select>

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