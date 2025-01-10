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

// Thêm người dùng
if (isset($_POST['add_user'])) {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Mã hóa mật khẩu
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    $sql = "INSERT INTO users (fullname, username, password, phone, role, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssss', $fullname, $username, $password, $phone, $role);

    if ($stmt->execute()) {
        $message = "Người dùng đã được thêm thành công!";
    } else {
        $message = "Lỗi khi thêm người dùng: " . $stmt->error;
    }

    $stmt->close();
}

// Xóa người dùng
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        $message = "Người dùng đã được xóa thành công!";
    } else {
        $message = "Lỗi khi xóa người dùng: " . $stmt->error;
    }

    $stmt->close();
}

// Lấy danh sách người dùng
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý tài khoản</title>
</head>

<body
    style="font-family: Arial, sans-serif; background: linear-gradient(to right, #4facfe, #00f2fe); margin: 0; padding: 0;">

    <!-- Header -->
    <header
        style="background: #007bff; color: white; padding: 15px; text-align: center; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <h1 style="margin: 0; font-size: 28px;">Quản lý tài khoản người dùng</h1>
    </header>

    <!-- Message -->
    <?php if (!empty($message)): ?>
        <p style="text-align: center; color: green; font-weight: bold;"><?= $message ?></p>
    <?php endif; ?>

    <!-- Form Thêm Người Dùng -->
    <main
        style="max-width: 1000px; margin: 20px auto; background: white; border-radius: 10px; padding: 20px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
        <h2 style="text-align: center; color: #343a40; margin-bottom: 20px;">Thêm tài khoản mới</h2>
        <form method="POST" action=""
            style="display: flex; flex-direction: column; gap: 15px; max-width: 600px; margin: auto;">
            <input type="text" name="fullname" placeholder="Họ và tên" required
                style="padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
            <input type="text" name="username" placeholder="Tên đăng nhập" required
                style="padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
            <input type="password" name="password" placeholder="Mật khẩu" required
                style="padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
            <input type="text" name="phone" placeholder="Số điện thoại" required
                style="padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
            <select name="role" required style="padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                <option value="user">Người dùng</option>
                <option value="admin">Quản trị viên</option>
            </select>
            <button type="submit" name="add_user"
                style="padding: 10px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;">Thêm
                tài khoản</button>
        </form>
    </main>

    <!-- Danh sách người dùng -->
    <main
        style="max-width: 1000px; margin: 20px auto; background: white; border-radius: 10px; padding: 20px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
        <h2 style="text-align: center; color: #343a40; margin-bottom: 20px;">Danh sách tài khoản</h2>
        <table border="1" style="width: 100%; border-collapse: collapse; text-align: center;">
            <thead style="background: #f8f9fa;">
                <tr>
                    <th>ID</th>
                    <th>Họ và tên</th>
                    <th>Tên đăng nhập</th>
                    <th>Số điện thoại</th>
                    <th>Vai trò</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['fullname']) ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td><?= htmlspecialchars($row['role']) ?></td>
                        <td>
                            <a href="edit-user.php?id=<?= $row['id'] ?>"
                                style="padding: 5px 10px; background: #ffc107; color: white; text-decoration: none; border-radius: 3px; margin-right: 5px;">Sửa</a>
                            <a href="manage-users.php?delete=<?= $row['id'] ?>"
                                style="padding: 5px 10px; background: #dc3545; color: white; text-decoration: none; border-radius: 3px;"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?')">Xóa</a>
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