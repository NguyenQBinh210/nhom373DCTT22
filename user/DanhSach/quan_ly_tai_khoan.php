<?php
require "Config/connect_db.php"; // Kết nối cơ sở dữ liệu

session_start();

// Giả sử bạn lưu tên đăng nhập trong session
$username = $_SESSION['username'] ?? null;
// Đồng bộ mã Đảng viên với tên đăng nhập
$data['maDangVien'] = $username;
// Lấy thông tin tài khoản hiện tại từ session
$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$sql2 = "SELECT * FROM lylichdangvien WHERE maDangVien = ?";
$stmt = $conn->prepare($sql2);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

$isEditingPassword = isset($_GET['edit_password']); // Kiểm tra trạng thái sửa mật khẩu

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isEditingPassword) {
    $newPassword = trim($_POST['newPassword']);
    $confirmPassword = trim($_POST['confirmPassword']);

    // Kiểm tra mật khẩu
    if (empty($newPassword) || empty($confirmPassword)) {
        $error = "Mật khẩu không được để trống.";
    } elseif ($newPassword !== $confirmPassword) {
        $error = "Mật khẩu xác nhận không khớp.";
    } else {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT); // Mã hóa mật khẩu
        $updateSql = "UPDATE users SET password = ? WHERE username = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ss", $hashedPassword, $username);

        if ($updateStmt->execute()) {
            $success = "Mật khẩu đã được cập nhật thành công!";
            header("Location: ?"); // Quay lại trạng thái ban đầu
            exit();
        } else {
            $error = "Có lỗi xảy ra: " . $conn->error;
        }
    }
}

// Khi cập nhật, đảm bảo rằng `maDangVien` luôn trùng với tên đăng nhập
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hoTen = trim($_POST['hoTen']);
    $ngaySinh = trim($_POST['ngaySinh']);
    $danToc = trim($_POST['danToc']);
    $gioiTinh = trim($_POST['gioiTinh']);
    $tonGiao = trim($_POST['tonGiao']);
    $queQuan = trim($_POST['queQuan']);
    $noiCuTru = trim($_POST['noiCuTru']);
    $soDienThoai = trim($_POST['soDienThoai']);
    $email = trim($_POST['email']);
   // Đồng bộ mã Đảng viên
    $maDangVien = $username;

    if (empty($errors)) {
        // Cập nhật cơ sở dữ liệu
        $sql = "UPDATE lylichdangvien SET hoTen = ?, ngaySinh = ?, danToc = ?, gioiTinh = ?, tonGiao = ?, queQuan = ?, noiCuTru = ?, soDienThoai = ?, email = ? WHERE maDangVien = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Lỗi truy vấn: " . $conn->error);
        }

        $stmt->bind_param("ssssssssss", $hoTen, $ngaySinh, $danToc, $gioiTinh, $tonGiao, $queQuan, $noiCuTru, $soDienThoai, $email, $maDangVien);

        if ($stmt->execute()) {
            echo "<p class='success'>Cập nhật thành công!</p>";
        } else {
            echo "<p class='error'>Lỗi cập nhật: " . $stmt->error . "</p>";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa thông tin Đảng viên</title>
    <style>
        .error { color: red; font-size: 30px; }
        .success { color: green; font-size: 30px; }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
        .success {
            color: green;
            margin-bottom: 15px;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }

    </style>
</head>
<body>
<div style="display: flex;flex-direction: row; gap:20px">
    <div class="container" style="width:30%">
    <h2>Quản lý tài khoản</h2>

        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <?php if ($isEditingPassword): ?>
            <!-- Form sửa mật khẩu -->
            <form method="POST">
                <label>Mật khẩu mới:</label>
                <input type="password" name="newPassword" placeholder="Nhập mật khẩu mới">

                <label>Xác nhận mật khẩu mới:</label>
                <input type="password" name="confirmPassword" placeholder="Xác nhận mật khẩu mới">

                <button type="submit">Lưu</button>
                <a href="?" style="display: inline-block; margin-top: 10px;">Hủy</a>
            </form>
        <?php else: ?>
    <!-- Hiển thị thông tin tài khoản -->
    <p><strong>Tên tài khoản:</strong> <?php echo $user['username']; ?></p>
    <p><strong>Vai trò:</strong> <?php echo $user['role']; ?></p>

    <a href="?edit_password=1">
        <button type="button">Sửa mật khẩu</button>
    </a>
<?php endif; ?>
</div>
    <div class="container" style="width: 70%;">
        <form method="POST">
            <label>Mã Đảng viên:</label>
            <input type="text" name="maDangVien" value="<?php echo isset($data['maDangVien']) ? $data['maDangVien'] : ''; ?>" readonly required>
            <label>Họ Tên:</label>
            <input type="text" name="hoTen" value="<?php echo isset($data['hoTen']) ? $data['hoTen'] : ''; ?>" required>
            <label>Ngày Sinh:</label>
            <input type="date" name="ngaySinh" value="<?php echo isset($data['ngaySinh']) ? $data['ngaySinh'] : ''; ?>" required>
            <label>Dân Tộc:</label>
            <input type="text" name="danToc" value="<?php echo isset($data['danToc']) ? $data['danToc'] : ''; ?>" required>
            <label>Giới Tính:</label>
            <select name="gioiTinh" required>
                <option value="Nam" <?php echo (isset($data['gioiTinh']) && $data['gioiTinh'] === 'Nam') ? 'selected' : ''; ?>>Nam</option>
                <option value="Nữ" <?php echo (isset($data['gioiTinh']) && $data['gioiTinh'] === 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
            </select>
            <label>Tôn Giáo:</label>
            <input type="text" name="tonGiao" value="<?php echo isset($data['tonGiao']) ? $data['tonGiao'] : ''; ?>" required>
            <label>Quê Quán:</label>
            <input type="text" name="queQuan" value="<?php echo isset($data['queQuan']) ? $data['queQuan'] : ''; ?>" required>
            <label>Nơi Cư Trú:</label>
            <input type="text" name="noiCuTru" value="<?php echo isset($data['noiCuTru']) ? $data['noiCuTru'] : ''; ?>" required>
            <label>Số Điện Thoại:</label>
            <input type="text" name="soDienThoai" value="<?php echo isset($data['soDienThoai']) ? $data['soDienThoai'] : ''; ?>" required>
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo isset($data['email']) ? $data['email'] : ''; ?>" required>
            <button type="submit">Cập nhật</button>
        </form>
    </div>
    </div>
</body>
</html>