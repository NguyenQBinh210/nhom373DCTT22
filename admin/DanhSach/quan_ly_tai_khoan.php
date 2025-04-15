<?php
require "Config/connect_db.php"; // Kết nối cơ sở dữ liệu

session_start(); 
// Lấy thông tin tài khoản hiện tại từ session
$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

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
$sql2 = "SELECT username, password, role FROM users where role ='user'";
$result = $conn->query($sql2);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý tài khoản</title>
    <style>
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
    <div style="display: flex;flex-direction: row; gap:20px;padding-left: 20px;padding-right: 20px;">
        <div class="container" style="width: 30%;">
                <h2>Quản lý tài khoản</h2>

                <?php if (!empty($error)): ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php endif; ?>

                <?php if (!empty($success)): ?>
                    <div class="success"><?php echo $success; ?></div>
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
                    <p><strong>Tên tài khoản:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                    <p><strong>Vai trò:</strong> <?php echo htmlspecialchars($user['role']); ?></p>

                    <a href="?edit_password=1">
                        <button type="button">Sửa mật khẩu</button>
                    </a>
                <?php endif; ?>
            </div>
        </body>
        <div class="container" style="width: 70%;">
            <h2>Danh sách tài khoản</h2>
            <table  class="table" style="margin-top: 20px;">
                <thead>
                    <tr>
                    <th scope="col">Tài khoản</th>
                    <th scope="col">Mật khẩu</th>
                    <th scope="col">role</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if ($result->num_rows > 0) {
                        // Hiển thị từng hàng dữ liệu
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['password']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>Không có dữ liệu</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
</div>
</html>
