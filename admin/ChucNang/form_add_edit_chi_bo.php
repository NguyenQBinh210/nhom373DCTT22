<?php
require "../Config/connect_db.php"; // Kết nối cơ sở dữ liệu

$isEdit = isset($_GET['maChiBo']); // Kiểm tra xem có tham số sửa hay không
$data = [];
$errors = [];

// Nếu là sửa, lấy thông tin hiện tại
if ($isEdit) {
    $maChiBo = $_GET['maChiBo'];
    $sql = "SELECT * FROM chibo WHERE maChiBo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $maChiBo);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
}

// Xử lý khi gửi form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $maChiBo = trim($_POST['maChiBo']);
    $tenChiBo = trim($_POST['tenChiBo']);
    $ngayThanhLap = trim($_POST['ngayThanhLap']);
    $diaDiem = trim($_POST['diaDiem']);
    $nganhLinhVuc = trim($_POST['nganhLinhVuc']);
    $biThuChiBo = trim($_POST['biThuChiBo']);
    $thongTinKhac = trim($_POST['thongTinKhac']);

    // Kiểm tra các trường trống
    if (empty($maChiBo)) $errors['maChiBo'] = "Mục 'Mã chi bộ' không được để trống";
    if (empty($tenChiBo)) $errors['tenChiBo'] = "Mục 'Tên chi bộ' không được để trống";
    if (empty($ngayThanhLap)) $errors['ngayThanhLap'] = "Mục 'Ngày thành lập' không được để trống";
    if (empty($diaDiem)) $errors['diaDiem'] = "Mục 'Địa điểm' không được để trống";
    if (empty($nganhLinhVuc)) $errors['nganhLinhVuc'] = "Mục 'Ngành/lĩnh vực' không được để trống";
    if (empty($biThuChiBo)) $errors['biThuChiBo'] = "Mục 'Bí thư chi bộ' không được để trống";

    if (empty($errors)) {
        if ($isEdit) {
            // Cập nhật thông tin chi bộ
            $sql = "UPDATE chibo SET 
                tenChiBo = ?, ngayThanhLap = ?, diaDiem = ?, nganhLinhVuc = ?, 
                biThuChiBo = ?, thongTinKhac = ? WHERE maChiBo = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", $tenChiBo, $ngayThanhLap, $diaDiem, $nganhLinhVuc, $biThuChiBo, $thongTinKhac, $maChiBo);
        } else {
            // Thêm mới chi bộ
            $sql = "INSERT INTO chibo (maChiBo, tenChiBo, ngayThanhLap, diaDiem, nganhLinhVuc, biThuChiBo, thongTinKhac) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", $maChiBo, $tenChiBo, $ngayThanhLap, $diaDiem, $nganhLinhVuc, $biThuChiBo, $thongTinKhac);
        }

        if ($stmt->execute()) {
            header("Location: ../chi_bo.php");
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
    <title><?php echo $isEdit ? "Sửa Chi Bộ" : "Thêm Chi Bộ"; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .form-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
        }
        .form-container h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-container label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }
        .form-container input,
        .form-container textarea,
        .form-container button {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            font-size: 14px;
            margin: -10px 0 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1><?php echo $isEdit ? "Sửa Chi Bộ" : "Thêm Chi Bộ"; ?></h1>
        <form method="POST">
            <label>Mã Chi Bộ:</label>
            <input type="text" name="maChiBo" value="<?php echo $isEdit ? $data['maChiBo'] : ''; ?>" <?php echo $isEdit ? 'readonly' : ''; ?> required>
            <?php if (!empty($errors['maChiBo'])) echo "<p class='error'>{$errors['maChiBo']}</p>"; ?>

            <label>Tên Chi Bộ:</label>
            <input type="text" name="tenChiBo" value="<?php echo $data['tenChiBo'] ?? ''; ?>" required>
            
            <label>Ngày Thành Lập:</label>
            <input type="date" name="ngayThanhLap" value="<?php echo $data['ngayThanhLap'] ?? ''; ?>" required>
            
            <label>Địa Điểm:</label>
            <input type="text" name="diaDiem" value="<?php echo $data['diaDiem'] ?? ''; ?>" required>
            
            <label>Ngành/Lĩnh Vực:</label>
            <input type="text" name="nganhLinhVuc" value="<?php echo $data['nganhLinhVuc'] ?? ''; ?>" required>
            
            <label>Bí Thư Chi Bộ:</label>
            <input type="text" name="biThuChiBo" value="<?php echo $data['biThuChiBo'] ?? ''; ?>" required>
            
            <label>Thông Tin Khác:</label>
            <textarea name="thongTinKhac" rows="3"><?php echo $data['thongTinKhac'] ?? ''; ?></textarea>
            
            <button type="submit"><?php echo $isEdit ? "Cập Nhật" : "Thêm Mới"; ?></button>
        </form>
    </div>
</body>
</html>
