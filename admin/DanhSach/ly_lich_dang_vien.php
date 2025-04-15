<?php
require "Config/connect_db.php";
// Lấy mã Đảng viên từ URL
if (isset($_GET['maDangVien'])) {
    $maDangVien = $_GET['maDangVien'];
    
    // Câu truy vấn kết hợp 2 bảng
    $sql = "SELECT lv.*, ct.* 
            FROM lylichdangvien lv 
            JOIN chi_tiet_dangvien ct ON lv.maDangVien = ct.maDangVien 
            WHERE lv.maDangVien = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $maDangVien);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    echo "<h1>Thông tin chi tiết Đảng viên</h1>";
    echo "<p><strong>Mã Đảng viên:</strong> " . $row['maDangVien'] . "</p>";
    echo "<p><strong>Họ và tên:</strong> " . $row['hoTen'] . "</p>";
    echo "<p><strong>Ngày sinh:</strong> " . $row['ngaySinh'] . "</p>";
    echo "<p><strong>Dân tộc:</strong> " . $row['danToc'] . "</p>";
    echo "<p><strong>Giới tính:</strong> " . $row['gioiTinh'] . "</p>";
    echo "<p><strong>Tôn giáo:</strong> " . $row['tonGiao'] . "</p>";
    echo "<p><strong>Quê quán:</strong> " . $row['queQuan'] . "</p>";
    echo "<p><strong>Nơi cư trú:</strong> " . $row['noiCuTru'] . "</p>";
    echo "<p><strong>Số điện thoại:</strong> " . $row['soDienThoai'] . "</p>";
    echo "<p><strong>Email:</strong> " . $row['email'] . "</p>";
    echo "<h2>Thông tin gia đình</h2>";
    echo "<p><strong>Họ tên cha:</strong> " . $row['hoTenCha'] . "</p>";
    echo "<p><strong>Năm sinh cha:</strong> " . $row['namSinhCha'] . "</p>";
    echo "<p><strong>Nghề nghiệp cha:</strong> " . $row['ngheNghiepCha'] . "</p>";
    echo "<p><strong>Quê của cha:</strong> " . $row['noiOCha'] . "</p>";
    echo "<p><strong>Họ tên mẹ:</strong> " . $row['hoTenMe'] . "</p>";
    echo "<p><strong>Năm sinh mẹ:</strong> " . $row['namSinhMe'] . "</p>";
    echo "<p><strong>Nghề nghiệp mẹ:</strong> " . $row['ngheNghiepMe'] . "</p>";
    echo "<p><strong>Quê của mẹ:</strong> " . $row['noiOMe'] . "</p>";
    echo "<p><strong>Họ tên vợ/chồng:</strong> " . $row['hoTenVoChong'] . "</p>";
    echo "<p><strong>Năm sinh vợ/chồng:</strong> " . $row['namSinhVoChong'] . "</p>";
    echo "<p><strong>Nghề vợ/chồng:</strong> " . $row['ngheNghiepVoChong'] . "</p>";
    echo "<p><strong>Nơi ở hiện nay:</strong> " . $row['noiOVoChong'] . "</p>";
    echo "<h2>Trình độ</h2>";
    echo "<p><strong>Trình độ học vấn:</strong> " . $row['trinhDoHocVan'] . "</p>";
    echo "<p><strong>Trình độ chuyên môn:</strong> " . $row['trinhDoChuyenMon'] . "</p>";
    echo "<p><strong>Trình độ lý luận chính trị:</strong> " . $row['trinhDoLyLuanChinhTri'] . "</p>";
    echo "<p><strong>Ngoại ngữ:</strong> " . $row['ngoaiNgu'] . "</p>";
    echo "<h2>Quá trình công tác</h2>";
    echo "<p><strong>Ngày vào Đảng:</strong> " . $row['ngayVaoDang'] . "</p>";
    echo "<p><strong>Ngày chính thức:</strong> " . $row['ngayChinhThuc'] . "</p>";
    echo "<p><strong>Quá trình công tác:</strong> " . $row['quaTrinhCongTac'] . "</p>";
    echo "<h2>Khen thưởng và kỷ luật</h2>";
    echo "<p><strong>Khen thưởng:</strong> " . $row['khenThuong'] . "</p>";
    echo "<p><strong>Kỷ luật:</strong> " . $row['kyLuat'] . "</p>";
} else {
    echo "<p>Không tìm thấy thông tin Đảng viên.</p>";
}
$stmt->close();
} else {
    echo "<p>Không có mã Đảng viên được cung cấp.</p>";
}

$conn->close();
?>
<div style="display: flex;justify-content: center; gap: 30px;">
    <button style="width:100px;height: 55px;border-radius: 20px;border:none;background-color: green;"><a href="dang_vien.php" style="color:#ffffff;text-decoration: none;">Quay lại</a>
</button>
    <button style="width:100px;height: 55px;border-radius: 20px;text-decoration: none;background-color: green;"><?php echo "<a href='../admin/ChucNang/form_edit_ly_lich.php?maDangVien=" . $row['maDangVien'] . "' class='edit'>Bổ sung thông tin</a>"?>
</button>
</div>
<div style="margin-bottom: 100px;"></div>