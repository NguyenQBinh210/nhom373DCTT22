<?php
require "Config/connect_db.php";
// Câu truy vấn lấy danh sách đảng viên
$sql = "SELECT * FROM lylichdangvien";
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
        <h1>Danh sách Đảng viên</h1>
        <button class="button-73" style="margin-right: 30px;">
            <a href="ChucNang/form_add_edit_dang_vien.php" style="text-decoration: none;">Thêm đảng viên</a>
        </button>
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
      <th scope="col">Hành động</th>
    </tr>
  </thead>
  <tbody>
    <?php
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
            echo "<td class='action-buttons'>";
            echo "<a href='../admin/ChucNang/form_add_edit_dang_vien.php?maDangVien=" . $row['maDangVien'] . "' class='edit'>Sửa</a>";
            echo "<a href='ChucNang/xoa_dang_vien.php?maDangVien=" . $row['maDangVien'] . "' class='delete' onclick='return confirm(\"Bạn có chắc chắn muốn xóa không?\");'>Xóa</a>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='11'>Không có dữ liệu</td></tr>";
    }
    ?>
  </tbody>
</table>
</div>