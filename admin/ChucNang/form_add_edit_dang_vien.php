<?php
require "../Config/connect_db.php"; // Kết nối cơ sở dữ liệu

$isEdit = isset($_GET['maDangVien']); // Kiểm tra xem có tham số sửa hay không
$data = [];
$errors = [];

// Nếu là sửa, lấy thông tin Đảng viên hiện tại
if ($isEdit) {
    $maDangVien = $_GET['maDangVien'];
    $sql = "SELECT * FROM lylichdangvien WHERE maDangVien = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $maDangVien);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
}

// Xử lý khi gửi form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $maDangVien = trim($_POST['maDangVien']);
    $hoTen = trim($_POST['hoTen']);
    $ngaySinh = trim($_POST['ngaySinh']);
    $danToc = trim($_POST['danToc']);
    $gioiTinh = trim($_POST['gioiTinh']);
    $tonGiao = trim($_POST['tonGiao']);
    $queQuan = trim($_POST['queQuan']);
    $noiCuTru = trim($_POST['noiCuTru']);
    $soDienThoai = trim($_POST['soDienThoai']);
    $email = trim($_POST['email']);

    // Kiểm tra các trường trống
    if (empty($maDangVien)) $errors['maDangVien'] = "Mục này không được để trống";
    if (empty($hoTen)) $errors['hoTen'] = "Mục này không được để trống";
    if (empty($ngaySinh)) $errors['ngaySinh'] = "Mục này không được để trống";
    if (empty($danToc)) $errors['danToc'] = "Mục này không được để trống";
    if (empty($gioiTinh)) $errors['gioiTinh'] = "Mục này không được để trống";
    if (empty($tonGiao)) $errors['tonGiao'] = "Mục này không được để trống";
    if (empty($queQuan)) $errors['queQuan'] = "Mục này không được để trống";
    if (empty($noiCuTru)) $errors['noiCuTru'] = "Mục này không được để trống";
    if (empty($soDienThoai)) $errors['soDienThoai'] = "Mục này không được để trống";
    if (empty($email)) $errors['email'] = "Mục này không được để trống";

    if (empty($errors)) {
        if (!$isEdit) { // Nếu thêm mới
            $checkQuery = "SELECT maDangVien FROM lylichdangvien WHERE maDangVien = ?";
            $checkStmt = $conn->prepare($checkQuery);
            $checkStmt->bind_param("s", $maDangVien);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();

            if ($checkResult->num_rows > 0) {
                $errors['maDangVien'] = "Mã Đảng viên '$maDangVien' đã tồn tại";
            }
        }
    }
    if (empty($errors)) {
        if ($isEdit) {
            // Cập nhật Đảng viên
            $sql = "UPDATE lylichdangvien SET hoTen = ?, ngaySinh = ?, danToc = ?, gioiTinh = ?, tonGiao = ?, queQuan = ?, noiCuTru = ?, soDienThoai = ?, email = ? WHERE maDangVien = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssss", $hoTen, $ngaySinh, $danToc, $gioiTinh, $tonGiao, $queQuan, $noiCuTru, $soDienThoai, $email, $maDangVien);
        } else {
            // Thêm mới Đảng viên
            $sql = "INSERT INTO lylichdangvien (maDangVien, hoTen, ngaySinh, danToc, gioiTinh, tonGiao, queQuan, noiCuTru, soDienThoai, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssss", $maDangVien, $hoTen, $ngaySinh, $danToc, $gioiTinh, $tonGiao, $queQuan, $noiCuTru, $soDienThoai, $email);
        }

        if ($stmt->execute()) {
            // Thêm mới mã Đảng viên vào chi_tiet_dangvien
            $sql2 = "INSERT INTO chi_tiet_dangvien (maDangVien) VALUES(?)";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("s", $maDangVien);

            if ($stmt2->execute()) {
                header("Location: ../dang_vien.php");
                exit();
            } else {
                echo "Lỗi khi thêm vào bảng chi_tiet_dangvien: " . $stmt2->error;
            }
        } else {
            echo "Lỗi khi thêm vào bảng lylichdangvien: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $isEdit ? "Sửa Đảng viên" : "Thêm Đảng viên"; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }       
        .error {
            color: red;
            font-size: 14px;
            font-weight: bold;
            margin-top: -10px;
            margin-bottom: 10px;
        }

        .form-container {
            width: 100%;
            max-width: 600px;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-container input,
        .form-container select,
        .form-container button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-container button {
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            border: none;
        }

        .form-container button:hover {
            background-color: #45a049;
        }

        .form-container .readonly {
            background-color: #f9f9f9;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1><?php echo $isEdit ? "Sửa Đảng viên" : "Thêm Đảng viên"; ?></h1>
        <form method="POST">
        <label>Mã Đảng viên:</label>
            <input type="text" name="maDangVien" value="<?php echo $isEdit ? $data['maDangVien']: ''; ?>" <?php echo $isEdit ? 'readonly' : ''; ?> required>
            <?php if (!empty($errors['maDangVien'])) echo "<p class='error'>{$errors['maDangVien']}</p>"; ?>
            
            
            <label>Họ Tên:</label>
            <input type="text" name="hoTen" value="<?php echo $isEdit ? $data['hoTen'] : ''; ?>" required>
            
            <label>Ngày Sinh:</label>
            <input type="date" name="ngaySinh" value="<?php echo $isEdit ? $data['ngaySinh'] : ''; ?>" required>
            
            <label>Dân Tộc:</label>
            <input type="text" name="danToc" value="<?php echo $isEdit ? $data['danToc'] : ''; ?>" required>
            
            <label>Giới Tính:</label>
            <select name="gioiTinh" required>
                <option value="Nam" <?php echo ($isEdit && $data['gioiTinh'] === 'Nam') ? 'selected' : ''; ?>>Nam</option>
                <option value="Nữ" <?php echo ($isEdit && $data['gioiTinh'] === 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
            </select>
            
            <label>Tôn Giáo:</label>
            <input type="text" name="tonGiao" value="<?php echo $isEdit ? $data['tonGiao'] : ''; ?>" required>
            
            <label>Quê Quán:</label>
            <input type="text" name="queQuan" value="<?php echo $isEdit ? $data['queQuan'] : ''; ?>" required>
            
            <label>Nơi Cư Trú:</label>
            <input type="text" name="noiCuTru" value="<?php echo $isEdit ? $data['noiCuTru'] : ''; ?>" required>
            
            <label>Số Điện Thoại:</label>
            <input type="text" name="soDienThoai" value="<?php echo $isEdit ? $data['soDienThoai'] : ''; ?>" required>
            
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $isEdit ? $data['email'] : ''; ?>" required>
            <button><a href="../dang_vien.php">Quay lại</a></button>
            <button type="submit"><?php echo $isEdit ? "Cập nhật" : "Thêm mới"; ?></button>
        </form>
    </div>
</body>
</html>
