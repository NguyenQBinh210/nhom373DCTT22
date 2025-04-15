<?php
require "../Config/connect_db.php"; // Kết nối cơ sở dữ liệu

$isEdit = isset($_GET['maLichTrinh']); // Kiểm tra xem có tham số sửa hay không
$data = [];
$errors = [];

// Nếu là sửa, lấy thông tin hiện tại
if ($isEdit) {
    $maLichTrinh = $_GET['maLichTrinh'];
    $sql = "SELECT * FROM lichtrinh WHERE maLichTrinh = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $maLichTrinh);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
}

// Xử lý khi gửi form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $maLichTrinh = trim($_POST['maLichTrinh']);
    $tenSuKien = trim($_POST['tenSuKien']);
    $moTa = trim($_POST['moTa']);
    $loaiHinh = trim($_POST['loaiHinh']);
    $nguoiChuTri = trim($_POST['nguoiChuTri']);
    $trangThai = trim($_POST['trangThai']);
    $diaDiem = trim($_POST['diaDiem']);
    $thoiGian = trim($_POST['thoiGian']);

    // Kiểm tra các trường trống
    if (empty($maLichTrinh)) $errors['maLichTrinh'] = "Mục 'Mã lịch trình' không được để trống";
    if (empty($tenSuKien)) $errors['tenSuKien'] = "Mục 'Tên sự kiện' không được để trống";
    if (empty($moTa)) $errors['moTa'] = "Mục 'Mô tả' không được để trống";
    if (empty($loaiHinh)) $errors['loaiHinh'] = "Mục 'Loại hình' không được để trống";
    if (empty($nguoiChuTri)) $errors['nguoiChuTri'] = "Mục 'Người chủ trì' không được để trống";
    if (empty($trangThai)) $errors['trangThai'] = "Mục 'Trạng thái' không được để trống";
    if (empty($diaDiem)) $errors['diaDiem'] = "Mục 'Địa điểm' không được để trống";
    if (empty($thoiGian)) $errors['thoiGian'] = "Mục 'Thời gian' không được để trống";

    if (empty($errors)) {
        if ($isEdit) {
            // Cập nhật thông tin lịch trình
            $sql = "UPDATE lichtrinh SET 
                tenSuKien = ?, moTa = ?, loaiHinh = ?, nguoiChuTri = ?, 
                trangThai = ?, diaDiem = ?, thoiGian = ? WHERE maLichTrinh = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssss", $tenSuKien, $moTa, $loaiHinh, $nguoiChuTri, $trangThai, $diaDiem, $thoiGian, $maLichTrinh);
        } else {
            // Thêm mới lịch trình
            $sql = "INSERT INTO lichtrinh (maLichTrinh, tenSuKien, moTa, loaiHinh, nguoiChuTri, trangThai, diaDiem, thoiGian) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssss", $maLichTrinh, $tenSuKien, $moTa, $loaiHinh, $nguoiChuTri, $trangThai, $diaDiem, $thoiGian);
        }

        if ($stmt->execute()) {
            header("Location: ../lich_trinh.php");
            exit();
        } else {
            echo "Lỗi: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $isEdit ? "Sửa Lịch Trình" : "Thêm Lịch Trình"; ?></title>
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
        <h1><?php echo $isEdit ? "Sửa Lịch Trình" : "Thêm Lịch Trình"; ?></h1>
        <form method="POST">
            <label>Mã Lịch Trình:</label>
            <input type="text" name="maLichTrinh" value="<?php echo $isEdit ? $data['maLichTrinh'] : ''; ?>" <?php echo $isEdit ? 'readonly' : ''; ?> required>
            <?php if (!empty($errors['maLichTrinh'])) echo "<p class='error'>{$errors['maLichTrinh']}</p>"; ?>

            <label>Tên Sự Kiện:</label>
            <input type="text" name="tenSuKien" value="<?php echo $data['tenSuKien'] ?? ''; ?>" required>
            <?php if (!empty($errors['tenSuKien'])) echo "<p class='error'>{$errors['tenSuKien']}</p>"; ?>
            
            <label>Mô Tả:</label>
            <textarea name="moTa" rows="4" required><?php echo $data['moTa'] ?? ''; ?></textarea>
            <?php if (!empty($errors['moTa'])) echo "<p class='error'>{$errors['moTa']}</p>"; ?>
            
            <label>Loại Hình:</label>
            <select name="loaiHinh" required>
                <option value="Họp thường kỳ" <?php echo (isset($loaiHinh) && $loaiHinh === 'Họp thường kỳ') ? 'selected' : ''; ?>>Họp thường kỳ</option>
                <option value="Họp khẩn cấp" <?php echo (isset($loaiHinh) && $loaiHinh === 'Họp khẩn cấp') ? 'selected' : ''; ?>>Họp khẩn cấp</option>
                <option value="Hội nghị" <?php echo (isset($loaiHinh) && $loaiHinh === 'Hội nghị') ? 'selected' : ''; ?>>Hội nghị</option>
                <option value="Hội thảo" <?php echo (isset($loaiHinh) && $loaiHinh === 'Hội thảo') ? 'selected' : ''; ?>>Hội thảo</option>
                <option value="Lễ kỷ niệm" <?php echo (isset($loaiHinh) && $loaiHinh === 'Lễ kỷ niệm') ? 'selected' : ''; ?>>Lễ kỷ niệm</option>
            </select>
            
            <label>Người Chủ Trì:</label>
            <input type="text" name="nguoiChuTri" value="<?php echo $data['nguoiChuTri'] ?? ''; ?>" required>
            <?php if (!empty($errors['nguoiChuTri'])) echo "<p class='error'>{$errors['nguoiChuTri']}</p>"; ?>
            
            <label>Trạng Thái:</label>
            <select name="trangThai" required>
                <option value="Đang chuẩn bị" <?php echo (isset($trangThai) && $trangThai === 'Đang chuẩn bị') ? 'selected' : ''; ?>>Đang chuẩn bị</option>
                <option value="Đã diễn ra" <?php echo (isset($trangThai) && $trangThai === 'Đã diễn ra') ? 'selected' : ''; ?>>Đã diễn ra</option>
                <option value="Đã kết thúc" <?php echo (isset($trangThai) && $trangThai === 'Đã kết thúc') ? 'selected' : ''; ?>>Đã kết thúc</option>
            </select>
            
            <label>Địa Điểm:</label>
            <input type="text" name="diaDiem" value="<?php echo $data['diaDiem'] ?? ''; ?>" required>
            <?php if (!empty($errors['diaDiem'])) echo "<p class='error'>{$errors['diaDiem']}</p>"; ?>
            
            <label>Thời Gian:</label>
            <input type="datetime-local" name="thoiGian" value="<?php echo isset($data['thoiGian']) ? date('Y-m-d\TH:i', strtotime($data['thoiGian'])) : ''; ?>" required>
            <?php if (!empty($errors['thoiGian'])) echo "<p class='error'>{$errors['thoiGian']}</p>"; ?>
            <button>
            <a href="../lich_trinh.php" style="text-decoration: none; color:#ffffff">
                    Quay lại
                </a>
            </button>
            <button type="submit"><?php echo $isEdit ? "Cập Nhật" : "Thêm Mới"; ?></button>
        </form>
    </div>
</body>
</html>