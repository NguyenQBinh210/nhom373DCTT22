<?php
// Kết nối tới cơ sở dữ liệu
$servername = "localhost"; // Tên server
$username = "root";        // Tên người dùng
$password = "";            // Mật khẩu
$database = "quan_ly_dang_vien"; // Tên cơ sở dữ liệu

$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>