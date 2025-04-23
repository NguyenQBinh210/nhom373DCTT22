<?php
require "Config/connect_db.php";

// Câu truy vấn lấy danh sách đảng viên
$sql = "SELECT maDangVien, hoTen, ngaySinh, danToc, gioiTinh, tonGiao, queQuan, noiCuTru, soDienThoai, email FROM lylichdangvien";
$result = $conn->query($sql);

?>

<div>
        <style>
      .action-buttons a {
          text-decoration: none;
          padding: 5px 10px;
          border-radius: 3px;
          margin-right: 5px;
          color: white;
      }
      .action-buttons .edit {
          background-color: #4CAF50; 
          border: 1px solid #4CAF50;
      }
      .action-buttons .delete {
          background-color: #f44336; 
          border: 1px solid #f44336;
      }
    </style>
    <div class="heading" style="display: flex; justify-content: space-between; margin-top: 30px">
        <h1>Dang sách Đảng viên</h1>
        <form method="GET" action="" style="margin-bottom: 20px; display: flex; justify-content: center;">
    <input type="text" name="search" placeholder="Tìm kiếm theo tên..." style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; width: 300px;">
    <button type="submit" style="margin-left: 10px; padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px;">Tìm kiếm</button>
  </form>
    </div>
    <table class="table" style="margin-top: 20px;">
  <thead>
    <tr>
      <th scope="col">Mã Đảng viên</th>
      <th scope="col">Họ Tên</th>
      <th scope="col">Ngày Sinh</th>
      <th scope="col">Dân Tộc</th>
      <th scope="col">Giới Tính</th>
      <th scope="col">Tôn Giáo</th>
      <th scope="col">Quê Quán</th>
      <th scope="col">Nơi Cư Trú</th>
      <th scope="col">Số Điện Thoại</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    if ($search) {
        $stmt = $conn->prepare("SELECT * FROM lylichdangvien 
                            WHERE hoTen LIKE ? 
                            OR maDangVien = ? 
                            OR soDienThoai = ?");
        $likeSearch = "%$search%";

        // Truyền đủ 3 tham số cho câu truy vấn
        $stmt->bind_param("sss", $likeSearch, $search, $search);

        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $result = $conn->query("SELECT * FROM lylichdangvien");
    }
    if ($result->num_rows > 0) {
        // Lặp qua từng hàng dữ liệu
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td><a href='detail.php?maDangVien=" . $row['maDangVien'] . "'>" . $row['maDangVien'] . "</a></td>";
            echo "<td>" . $row['hoTen'] . "</td>";
            echo "<td>" . $row['ngaySinh'] . "</td>";
            echo "<td>" . $row['danToc'] . "</td>";
            echo "<td>" . $row['gioiTinh'] . "</td>";
            echo "<td>" . $row['tonGiao'] . "</td>";
            echo "<td>" . $row['queQuan'] . "</td>";
            echo "<td>" . $row['noiCuTru'] . "</td>";
            echo "<td>" . $row['soDienThoai'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='11'>Không có dữ liệu</td></tr>";
    }
    ?>
    <?php
if (isset($_GET['maDangVien'])) {
    $maDangVien = $_GET['maDangVien'];
    $stmt = $conn->prepare("SELECT * FROM lylichdangvien WHERE maDangVien = ?;
                            ");
    $stmt->bind_param("s", $maDangVien);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $detail = $result->fetch_assoc();
        echo "<h2>Thông tin chi tiết Đảng viên</h2>";
        echo "<p>Mã Đảng viên: " . $detail['maDangVien'] . "</p>";
        echo "<p>Họ Tên: " . $detail['hoTen'] . "</p>"; 
        echo "<p>Ngày Sinh: " . $detail['ngaySinh'] . "</p>";
        echo "<p>Dân Tộc: " . $detail['danToc'] . "</p>";
        echo "<p>Giới Tính: " . $detail['gioiTinh'] . "</p>";
        echo "<p>Tôn Giáo: " . $detail['tonGiao'] . "</p>";
        echo "<p>Quê Quán: " . $detail['queQuan'] . "</p>";
        echo "<p>Nơi Cư Trú: " . $detail['noiCuTru'] . "</p>";
        echo "<p>Số Điện Thoại: " . $detail['soDienThoai'] . "</p>";
        echo "<p>Email: " . $detail['email'] . "</p>";
    } else {
        echo "<p>Không tìm thấy thông tin Đảng viên.</p>";
    }
}
?>

  </tbody>
</table>
</div>