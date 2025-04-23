<?php
require "Config/connect_db.php";
// Câu truy vấn lấy danh sách đảng viên
$sql = "SELECT * FROM chibo";
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
          background-color: #4CAF50; /* Màu xanh */
          border: 1px solid #4CAF50;
      }
      .action-buttons .delete {
          background-color: #f44336; /* Màu đỏ */
          border: 1px solid #f44336;
      }
.button-73 {
  appearance: none;
  background-color: #FFFFFF;
  border-radius: 40em;
  border-style: none;
  box-shadow: #ADCFFF 0 -12px 6px inset;
  box-sizing: border-box;
  color: #000000;
  cursor: pointer;
  display: inline-block;
  font-family: -apple-system,sans-serif;
  font-size: 24px;
  font-weight: 700;
  letter-spacing: -.24px;
  margin: 0;
  outline: none;
  padding: 20px 30px;
  quotes: auto;
  text-align: center;
  text-decoration: none;
  transition: all .15s;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
}

.button-73:hover {
  background-color: #FFC229;
  box-shadow: #FF6314 0 -6px 8px inset;
  transform: scale(1.125);
}

.button-73:active {
  transform: scale(1.025);
}

@media (min-width: 768px) {
  .button-73 {
    font-size: 1.5rem;
    padding: .75rem 2rem;
  }
}
    </style>
    <div class="heading" style="display: flex; justify-content: space-between; margin-top: 30px">
        <h1>Dang sách chi bộ</h1>
        <form method="GET" action="" style="margin-bottom: 20px; display: flex; justify-content: center;">
    <input type="text" name="search" placeholder="Tìm kiếm theo tên..." style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; width: 300px;">
    <button type="submit" style="margin-left: 10px; padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px;">Tìm kiếm</button>
  </form>
    </div>
    <table class="table" style="margin-top: 20px;">
  <thead>
    <tr>
      <th scope="col">Mã chi bộ</th>
      <th scope="col">Tên chi bộ</th>
      <th scope="col">Ngày thành lập</th>
      <th scope="col">Địa điểm</th>
      <th scope="col">Ngành/lĩnh vực</th>
      <th scope="col">Bí thư chi bộ</th>
      <th scope="col">Số lượng</th>
      <th scope="col">Thông tin khác</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    if ($search) {
        $stmt = $conn->prepare("SELECT * FROM chibo WHERE tenChiBo LIKE ?");
        $likeSearch = "%$search%";
        $stmt->bind_param("s", $likeSearch);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $result = $conn->query("SELECT * FROM chibo");
    }
    if ($result->num_rows > 0) {
        // Lặp qua từng hàng dữ liệu
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['maChiBo'] . "</td>";
            echo "<td>" . $row['tenChiBo'] . "</td>";
            echo "<td>" . $row['ngayThanhLap'] . "</td>";
            echo "<td>" . $row['diaDiem'] . "</td>";
            echo "<td>" . $row['nganhLinhVuc'] . "</td>";
            echo "<td>" . $row['biThuChiBo'] . "</td>";
            echo "<td>" . $row['soLuongDangVien'] . "</td>";
            echo "<td>" . $row['thongTinKhac'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='11'>Không có dữ liệu</td></tr>";
    }
    ?>
  </tbody>
</table>
</div>