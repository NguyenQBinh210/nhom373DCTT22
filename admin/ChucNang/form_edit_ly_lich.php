<?php
require "../Config/connect_db.php"; // Kết nối cơ sở dữ liệu

// Kiểm tra nếu có mã đảng viên truyền vào để sửa
if (!isset($_GET['maDangVien'])) {
    die("Thiếu thông tin mã đảng viên.");
}

$maDangVien = $_GET['maDangVien'];
$errors = [];
$data = [];

// Lấy thông tin hiện tại của đảng viên
$sql = "SELECT * FROM chi_tiet_dangvien WHERE maDangVien = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $maDangVien);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Không tìm thấy thông tin đảng viên với mã: $maDangVien");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = [
        'hoTenCha' => 'Họ tên Cha',
        'namSinhCha' => 'Năm sinh Cha',
        'ngheNghiepCha' => 'Nghề nghiệp Cha',
        'noiOCha' => 'Nơi ở Cha',
        'hoTenMe' => 'Họ tên Mẹ',
        'namSinhMe' => 'Năm sinh Mẹ',
        'ngheNghiepMe' => 'Nghề nghiệp Mẹ',
        'noiOMe' => 'Nơi ở Mẹ',
        'hoTenVoChong' => 'Họ tên Vợ/Chồng',
        'namSinhVoChong' => 'Năm sinh Vợ/Chồng',
        'ngheNghiepVoChong' => 'Nghề nghiệp Vợ/Chồng',
        'noiOVoChong' => 'Nơi ở Vợ/Chồng',
        'soLuongCon' => 'Số lượng con',
        'trinhDoHocVan' => 'Trình độ học vấn',
        'trinhDoChuyenMon' => 'Trình độ chuyên môn',
        'trinhDoLyLuanChinhTri' => 'Trình độ lý luận chính trị',
        'ngoaiNgu' => 'Ngoại ngữ',
        'ngayVaoDang' => 'Ngày vào Đảng',
        'ngayChinhThuc' => 'Ngày chính thức',
        'quaTrinhCongTac' => 'Quá trình công tác',
        'khenThuong' => 'Khen thưởng',
        'kyLuat' => 'Kỷ luật',
    ];

    // Kiểm tra dữ liệu đầu vào
    foreach ($fields as $field => $label) {
        if (empty(trim($_POST[$field]))) {
            $errors[$field] = "Mục '$label' không được để trống";
        } else {
            $data[$field] = trim($_POST[$field]);
        }
    }

    if (empty($errors)) {
        // Cập nhật dữ liệu
        $sql = "UPDATE chi_tiet_dangvien SET 
            hoTenCha = ?, namSinhCha = ?, ngheNghiepCha = ?, noiOCha = ?,
            hoTenMe = ?, namSinhMe = ?, ngheNghiepMe = ?, noiOMe = ?,
            hoTenVoChong = ?, namSinhVoChong = ?, ngheNghiepVoChong = ?,
            noiOVoChong = ?, soLuongCon = ?, trinhDoHocVan = ?,
            trinhDoChuyenMon = ?, trinhDoLyLuanChinhTri = ?, ngoaiNgu = ?,
            ngayVaoDang = ?, ngayChinhThuc = ?, quaTrinhCongTac = ?, khenThuong = ?,kyLuat = ?
            WHERE maDangVien = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "sisssisssississssssssss", 
            $data['hoTenCha'], 
            $data['namSinhCha'], 
            $data['ngheNghiepCha'], 
            $data['noiOCha'],
            $data['hoTenMe'], 
            $data['namSinhMe'], 
            $data['ngheNghiepMe'], 
            $data['noiOMe'],
            $data['hoTenVoChong'], 
            $data['namSinhVoChong'],
             $data['ngheNghiepVoChong'], 
            $data['noiOVoChong'], 
            $data['soLuongCon'], 
            $data['trinhDoHocVan'], 
            $data['trinhDoChuyenMon'], 
            $data['trinhDoLyLuanChinhTri'], 
            $data['ngoaiNgu'], 
            $data['ngayVaoDang'], 
            $data['ngayChinhThuc'], 
            $data['quaTrinhCongTac'], 
            $data['khenThuong'], 
            $data['kyLuat'],
            $maDangVien
        );

        if ($stmt->execute()) {
            header("Location: ../dang_vien.php");
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
    <title>Document</title>
</head>
<body>
    
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
    <div class="form-container">
        <h1>Sửa chi tiết Đảng viên</h1>
        <form method="POST">
            <label>Mã Đảng viên:</label>
            <input type="text" name="maDangVien" value="<?php echo $data['maDangVien'] ?? ''; ?>" readonly>
    
                <label>Họ Tên Cha:</label>
                <input type="text" name="hoTenCha" value="<?php echo $data['hoTenCha'] ?? ''; ?>">
    
                <label>Năm Sinh Cha:</label>
                <input type="text" name="namSinhCha" value="<?php echo $data['namSinhCha'] ?? ''; ?>">
    
                <label>Nghề Nghiệp Cha:</label>
                <input type="text" name="ngheNghiepCha" value="<?php echo $data['ngheNghiepCha'] ?? ''; ?>">
    
                <label>Nơi Ở Cha:</label>
                <input type="text" name="noiOCha" value="<?php echo $data['noiOCha'] ?? ''; ?>">
    
                <label>Họ Tên Mẹ:</label>
                <input type="text" name="hoTenMe" value="<?php echo $data['hoTenMe'] ?? ''; ?>">
    
                <label>Năm Sinh Mẹ:</label>
                <input type="text" name="namSinhMe" value="<?php echo $data['namSinhMe'] ?? ''; ?>">
    
                <label>Nghề Nghiệp Mẹ:</label>
                <input type="text" name="ngheNghiepMe" value="<?php echo $data['ngheNghiepMe'] ?? ''; ?>">
    
                <label>Nơi Ở Mẹ:</label>
                <input type="text" name="noiOMe" value="<?php echo $data['noiOMe'] ?? ''; ?>">
    
                <label>Họ Tên Vợ/Chồng:</label>
                <input type="text" name="hoTenVoChong" value="<?php echo $data['hoTenVoChong'] ?? ''; ?>">
    
                <label>Năm Sinh Vợ/Chồng:</label>
                <input type="text" name="namSinhVoChong" value="<?php echo $data['namSinhVoChong'] ?? ''; ?>">
    
                <label>Nghề Nghiệp Vợ/Chồng:</label>
                <input type="text" name="ngheNghiepVoChong" value="<?php echo $data['ngheNghiepVoChong'] ?? ''; ?>">
    
                <label>Nơi Ở Vợ/Chồng:</label>
                <input type="text" name="noiOVoChong" value="<?php echo $data['noiOVoChong'] ?? ''; ?>">
    
                <label>Số Lượng Con:</label>
                <input type="number" name="soLuongCon" value="<?php echo $data['soLuongCon'] ?? ''; ?>">
    
                <label>Trình Độ Học Vấn:</label>
                <input type="text" name="trinhDoHocVan" value="<?php echo $data['trinhDoHocVan'] ?? ''; ?>">
    
                <label>Trình Độ Chuyên Môn:</label>
                <input type="text" name="trinhDoChuyenMon" value="<?php echo $data['trinhDoChuyenMon'] ?? ''; ?>">
    
                <label>Trình Độ Lý Luận Chính Trị:</label>
                <input type="text" name="trinhDoLyLuanChinhTri" value="<?php echo $data['trinhDoLyLuanChinhTri'] ?? ''; ?>">
    
                <label>Ngoại Ngữ:</label>
                <input type="text" name="ngoaiNgu" value="<?php echo $data['ngoaiNgu'] ?? ''; ?>">
    
                <label>Ngày Vào Đảng:</label>
                <input type="date" name="ngayVaoDang" value="<?php echo $data['ngayVaoDang'] ?? ''; ?>">
    
                <label>Ngày Chính Thức:</label>
                <input type="date" name="ngayChinhThuc" value="<?php echo $data['ngayChinhThuc'] ?? ''; ?>">
    
                <label>Quá Trình Công Tác:</label>
                <textarea name="quaTrinhCongTac" rows="5"><?php echo $data['quaTrinhCongTac'] ?? ''; ?></textarea>
    
                <label>Khen Thưởng:</label>
                <textarea name="khenThuong" rows="3"><?php echo $data['khenThuong'] ?? ''; ?></textarea>
                <label>Kỷ luật: </label>
                <textarea name="kyLuat" rows="3"><?php echo $data['kyLuat'] ?? ''; ?></textarea>
                <a href="../dang_vien.php" style="text-decoration: none;">
                    <button type="button" style="background-color: #ddd; color: #333;">Quay lại</button>
                </a>
                <button type="submit" style="background-color: #4CAF50; color: white;">Cập nhật</button>
            </form>
        </div>
</body>
</html>
