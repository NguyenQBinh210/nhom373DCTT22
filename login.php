<?php
// Kết nối tới cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quan_ly_dang_vien";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$error_username = "";
$error_password = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Truy vấn thông tin người dùng
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                // Kiểm tra quyền
                session_start();
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] === 'admin') {
                    header("Location: admin/index.php");
                } elseif ($user['role'] === 'user') {
                    header("Location: user/index.php");
                } else {
                    $error_password = "Quyền không hợp lệ!";
                }
                exit();
            } else {
                $error_password = "Mật khẩu không đúng!";
            }
        } else {
            $error_username = "Tên đăng nhập không tồn tại!";
        }
        $stmt->close();
    } else if (isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $role = $_POST['role'];
    
        // Kiểm tra mật khẩu và xác nhận mật khẩu
        if ($password !== $confirm_password) {
            $error_username = "Mật khẩu và xác nhận mật khẩu không khớp!";
        } else {
            // Kiểm tra xem tên đăng nhập đã tồn tại hay chưa
            $check_sql = "SELECT * FROM users WHERE username = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bind_param("s", $username);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
    
            if ($check_result->num_rows > 0) {
                $error_username = "Tên đăng nhập đã tồn tại, vui lòng chọn tên khác!";
            } else {
                // Hash mật khẩu
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
                // Thêm vào bảng lylichdangvien trước
                $add_lylich_sql = "INSERT INTO lylichdangvien (maDangVien) VALUES (?)";
                $add_lylich_stmt = $conn->prepare($add_lylich_sql);
                $add_lylich_stmt->bind_param("s", $username);
                // Thêm vào bảng lylichdangvien trước
                $add_chitiet_sql = "INSERT INTO chi_tiet_dangvien (maDangVien) VALUES (?)";
                $add_chitiet_stmt = $conn->prepare($add_chitiet_sql);
                $add_chitiet_stmt->bind_param("s", $username);
    
                if ($add_lylich_stmt->execute()&&$add_chitiet_stmt->execute()) {
                    // Thêm vào bảng users nếu thêm vào lylichdangvien thành công
                    $sql = "INSERT INTO users (username, password, role, maDangVien) VALUES (?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssss", $username, $hashed_password, $role, $username);
    
                    if ($stmt->execute()) {
                        $error_username = "Đăng ký thành công!";
                    } else {
                        $error_username = "Lỗi SQL (users): " . $stmt->error;
                    }
    
                    $stmt->close();
                } else {
                    $error_username = "Lỗi SQL (lylichdangvien): " . $add_lylich_stmt->error;
                }
    
                $add_lylich_stmt->close();
            }
    
            $check_stmt->close();
        }
    }
       
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập & Đăng ký</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body style="
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url('img/OIP.jpeg'); 
            background-size: cover;  
            background-position: center;  
            background-repeat: no-repeat;">
<div class="container">
    <input type="checkbox" id="check">
    <div class="login form">
        <header>Đăng nhập</header>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Nhập tên đăng nhập" required>
            <?php if ($error_username && isset($_POST['login'])): ?>
                <p style="color: red; font-size: 14px;"> <?php echo $error_username; ?> </p>
            <?php endif; ?>
            <input type="password" name="password" placeholder="Nhập mật khẩu" required>
            <?php if ($error_password && isset($_POST['login'])): ?>
                <p style="color: red; font-size: 14px;"> <?php echo $error_password; ?> </p>
            <?php endif; ?>
            <button type="submit" name="login" class="button">Đăng nhập</button>
        </form>
        <div class="signup">
            <span>Bạn chưa có tài khoản?
                <label for="check">Đăng ký</label>
            </span>
        </div>
    </div>
    <div class="registration form">
        <header>Đăng ký</header>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Nhập tên đăng nhập" required>
            <input type="password" name="password" placeholder="Tạo mật khẩu" required>
            <input type="password" name="confirm_password" placeholder="Xác nhận mật khẩu" required>
            <label for="role">Chọn quyền:</label>
            <select name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit" name="register" class="button">Đăng ký</button>
        </form>
        <div class="signup">
            <span>Bạn đã có tài khoản?
                <label for="check">Đăng nhập</label>
            </span>
        </div>
    </div>
</div>
</body>
</html>
