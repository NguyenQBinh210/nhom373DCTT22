<?php
    require "Config/connect_db.php";

    // Câu truy vấn lấy danh sách đảng viên
    $sql = "SELECT * FROM lichtrinh";
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
        <h1>Lịch trình hoạt động của Đảng</h1>
        <form method="GET" action="" style="margin-bottom: 20px; display: flex; justify-content: center;">
    <input type="text" name="search" placeholder="Tìm kiếm theo tên..." style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; width: 300px;">
    <button type="submit" style="margin-left: 10px; padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px;">Tìm kiếm</button>
  </form>
    </div>
    <table class="table" style="margin-top: 20px;">
  <thead>
    <tr>
      <th scope="col">Tên sự kiên</th>
      <th scope="col">Mô tả</th>
      <th scope="col">Loại hình</th>
      <th scope="col">Người chủ trì</th>
      <th scope="col">Trạng thái</th>
      <th scope="col">Địa điểm</th>
      <th scope="col">Thời gian</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    if ($search) {
        $stmt = $conn->prepare("SELECT * FROM lichtrinh
                            WHERE tenSuKien LIKE ? 
                            OR moTa = ? 
                            OR loaiHinh = ?");
        $likeSearch = "%$search%";

        // Truyền đủ 3 tham số cho câu truy vấn
        $stmt->bind_param("sss", $likeSearch, $search, $search);

        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $result = $conn->query("SELECT * FROM lichtrinh");
    }
    if ($result->num_rows > 0) {
        // Lặp qua từng hàng dữ liệu
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['tenSuKien'] . "</td>";
            echo "<td>" . $row['moTa'] . "</td>";
            echo "<td>" . $row['loaiHinh'] . "</td>";
            echo "<td>" . $row['nguoiChuTri'] . "</td>";
            echo "<td>" . $row['trangThai'] . "</td>";
            echo "<td>" . $row['diaDiem'] . "</td>";
            echo "<td>" . $row['thoiGian'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='11'>Không có dữ liệu</td></tr>";
    }
    ?>
    <?php
if (isset($_GET['id'])) {
    $id= $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM lichtrinh WHERE id = ?;
                            ");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $detail = $result->fetch_assoc();
        echo "<h2>Lịch trình sự kiện Đảng</h2>";
        echo "<p>Mã Đảng viên: " . $detail['tenSuKien'] . "</p>";
        echo "<p>Họ Tên: " . $detail['moTa'] . "</p>"; 
        echo "<p>Ngày Sinh: " . $detail['loaiHinh'] . "</p>";
        echo "<p>Dân Tộc: " . $detail['nguoiChuTri'] . "</p>";
        echo "<p>Giới Tính: " . $detail['trangThai'] . "</p>";
        echo "<p>Tôn Giáo: " . $detail['diaDiem'] . "</p>";
        echo "<p>Quê Quán: " . $detail['thoiGian'] . "</p>";
    } else {
        echo "<p>Không tìm thấy thông tin lịch trình.</p>";
    }
}
?>

  </tbody>
</table>
</div>