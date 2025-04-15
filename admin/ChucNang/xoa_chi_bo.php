<?php
require "../Config/connect_db.php";
if (isset($_GET['maChiBo'])) {
    $maChiBo = $_GET['maChiBo'];

    // Tạo câu truy vấn xóa
    $sql = "DELETE FROM chibo WHERE maChiBo = ?";

    // Chuẩn bị câu truy vấn
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $maChiBo);

    // Thực thi câu truy vấn
    if ($stmt->execute()) {
        echo "<script>alert('Xóa chi bộ thành công.'); window.location.href = '../chi_bo.php';</script>";
    } else {
        echo "<script>alert('Xóa chi bộ thất bại: " . $stmt->error . "'); window.location.href = '../chi_bo.php';</script>";
    }

    // Đóng câu truy vấn và kết nối
    $stmt->close();
} else {
    echo "<script>alert('Không tìm thấy mã chi bộ.'); window.location.href = '../chi_bo.php';</script>";
}
?>