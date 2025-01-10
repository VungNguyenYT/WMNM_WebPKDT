<?php
session_start();

// Kết nối cơ sở dữ liệu
$conn = new mysqli('localhost', 'root', '', 'mnm_pkdt');

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý khi người dùng gửi form đăng nhập
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Truy vấn tìm kiếm người dùng theo username
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Lỗi SQL: " . $conn->error);
    }

    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Kiểm tra nếu username tồn tại
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Kiểm tra mật khẩu
        if (password_verify($password, $user['password'])) {
            // Lưu thông tin người dùng vào session
            $_SESSION['user'] = [
                'id' => $user['id'],
                'fullname' => $user['fullname'],
                'username' => $user['username'],
                'role' => $user['role']
            ];

            // Chuyển hướng tùy theo vai trò
            if ($user['role'] == 'admin') {
                header('Location: admin/dashboard.php'); // Chuyển đến Dashboard
                exit();
            } else {
                header('Location: index.php'); // Chuyển đến trang chủ
                exit();
            }

        } else {
            echo "<p style='color: red; text-align: center;'>Sai mật khẩu!</p>";
        }
    } else {
        echo "<p style='color: red; text-align: center;'>Tên đăng nhập không tồn tại!</p>";
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
    <title>Đăng nhập</title>
</head>

<body
    style="font-family: Arial, sans-serif; background: linear-gradient(to right, #000046, #1cb5e0); margin: 0; padding: 0; color: #fff; text-align: center;">

    <h1 style="margin-top: 50px;">Đăng nhập</h1>
    <form method="POST" action=""
        style="max-width: 400px; margin: 30px auto; background: rgba(255, 255, 255, 0.1); padding: 20px; border-radius: 10px;">
        <label for="username" style="display: block; margin-bottom: 10px;">Tên đăng nhập:</label>
        <input type="text" name="username" required
            style="width: 100%; padding: 10px; margin-bottom: 20px; border: none; border-radius: 5px;">

        <label for="password" style="display: block; margin-bottom: 10px;">Mật khẩu:</label>
        <input type="password" name="password" required
            style="width: 100%; padding: 10px; margin-bottom: 20px; border: none; border-radius: 5px;">

        <button type="submit"
            style="padding: 10px 20px; background: #005bea; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Đăng
            nhập</button>
    </form>
    <p style="margin-top: 20px;">Chưa có tài khoản? <a href="register.php"
            style="color: #00c6ff; text-decoration: none;">Đăng ký ngay</a></p>
</body>

</html>