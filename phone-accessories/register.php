<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'mnm_pkdt');

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$error = ""; // Biến lưu lỗi

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone = $_POST['phone'];
    $role = $_POST['role']; // Lấy giá trị vai trò (user hoặc admin)
    $created_at = date('Y-m-d H:i:s');
    $updated_at = $created_at;

    // Kiểm tra mật khẩu khớp nhau
    if ($password !== $confirm_password) {
        $error = "Mật khẩu và nhập lại mật khẩu không khớp!";
    } else {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT); // Mã hóa mật khẩu

        // Kiểm tra username đã tồn tại chưa
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Lỗi SQL: " . $conn->error);
        }

        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Tên đăng nhập đã tồn tại!";
        } else {
            // Thêm tài khoản mới với vai trò
            $sql = "INSERT INTO users (fullname, username, password, phone, role, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Lỗi SQL: " . $conn->error);
            }

            $stmt->bind_param('sssssss', $fullname, $username, $password_hashed, $phone, $role, $created_at, $updated_at);
            if ($stmt->execute()) {
                echo "<p style='color: green; text-align: center;'>Đăng ký thành công! <a href='login.php'>Đăng nhập</a></p>";
            } else {
                $error = "Lỗi khi đăng ký tài khoản: " . $stmt->error;
            }
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
</head>

<body
    style="font-family: Arial, sans-serif; background: linear-gradient(to right, #6a11cb, #2575fc); margin: 0; padding: 0; color: #fff; text-align: center;">

    <h1 style="margin-top: 50px;">Đăng ký tài khoản</h1>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" action=""
        style="max-width: 400px; margin: 30px auto; background: rgba(255, 255, 255, 0.1); padding: 20px; border-radius: 10px;">
        <label for="fullname" style="display: block; margin-bottom: 10px;">Họ và tên:</label>
        <input type="text" name="fullname" required
            style="width: 100%; padding: 10px; margin-bottom: 20px; border: none; border-radius: 5px;">

        <label for="username" style="display: block; margin-bottom: 10px;">Tên đăng nhập:</label>
        <input type="text" name="username" required
            style="width: 100%; padding: 10px; margin-bottom: 20px; border: none; border-radius: 5px;">

        <label for="password" style="display: block; margin-bottom: 10px;">Mật khẩu:</label>
        <input type="password" name="password" required
            style="width: 100%; padding: 10px; margin-bottom: 20px; border: none; border-radius: 5px;">

        <label for="confirm_password" style="display: block; margin-bottom: 10px;">Nhập lại mật khẩu:</label>
        <input type="password" name="confirm_password" required
            style="width: 100%; padding: 10px; margin-bottom: 20px; border: none; border-radius: 5px;">

        <label for="phone" style="display: block; margin-bottom: 10px;">Số điện thoại:</label>
        <input type="text" name="phone" required
            style="width: 100%; padding: 10px; margin-bottom: 20px; border: none; border-radius: 5px;">

        <label for="role" style="display: block; margin-bottom: 10px;">Vai trò:</label>
        <select name="role" required
            style="width: 100%; padding: 10px; margin-bottom: 20px; border: none; border-radius: 5px;">
            <option value="user">Người dùng</option>
            <option value="admin">Quản trị viên</option>
        </select>

        <button type="submit"
            style="padding: 10px 20px; background: #00c6ff; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Đăng
            ký</button>
    </form>

    <p style="margin-top: 20px;">Đã có tài khoản? <a href="login.php"
            style="color: #00c6ff; text-decoration: none;">Đăng nhập ngay</a></p>

</body>

</html>