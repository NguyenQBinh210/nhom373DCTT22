<?php
require "../Config/connect_db.php";

// Kiểm tra xem maDangVien có được gửi qua URL  hay không
if (isset($_GET['maDangVien'])) {
    $maDangVien = $_GET['maDangVien'];

    // Xóa tài khoản
    $sql1 = "DELETE FROM users WHERE maDangVien = ?";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param('s', $maDangVien);
    $stmt1->execute();

    // Xóa chi tiết đảng viên
    $sql2 = "DELETE FROM chi_tiet_dangvien WHERE maDangVien = ?";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param('s', $maDangVien);
    $stmt2->execute();

    // Xóa lý lịch đảng viên
    $sql3 = "DELETE FROM lylichdangvien WHERE maDangVien = ?";
    $stmt3 = $conn->prepare($sql3);
    $stmt3->bind_param('s', $maDangVien);
    $stmt3->execute();

    if ($stmt1->affected_rows > 0 || $stmt2->affected_rows > 0 || $stmt3->affected_rows > 0) {
        echo "<script>alert('Xóa Đảng viên thành công.'); window.location.href = '../dang_vien.php';</script>";
    } else {
        echo "<script>alert('Xóa Đảng viên thất bại: " . $stmt->error . "'); window.location.href = '../dang_vien.php';</script>";
    }

    // Đóng câu truy vấn và kết nối
    $stmt->close();
} else {
    echo "<script>alert('Không tìm thấy mã Đảng viên.'); window.location.href = '../dang_vien.php';</script>";
}
?>