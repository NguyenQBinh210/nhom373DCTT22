<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đảng viên</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/danhsach.css">
    <link rel="stylesheet" href="../css/trangchu.css">
    <script>
        function confirmLogout(event) {
            if (!confirm("Bạn có chắc chắn muốn đăng xuất không?")) {
                event.preventDefault();
            }
        }
        </script>
</head>
<body>
    <div class="header">
        <a href="#" style="margin-left: 10px;">
            <img src="../img/R.jpg" alt="Image">
        </a>

        <div class="chuc-nang">
            <ul>

                <li><a href="index.php" class="tuy-chon">Trang chủ</a></li>
                <li><a href="dang_vien.php" class="tuy-chon">Đảng viên</a></li>
                <li><a href="chi_bo.php" class="tuy-chon">Chi bộ</a></li>
                <li><a href="lich_trinh.php" class="tuy-chon">Lịch trình</a></li>
            </ul>
        </div>
        <div class="user">
        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-user" style="color: #fff;margin-top: 15px"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="10" r="3"/><path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662"/></svg>
        <ul>
            <li><a href="taikhoan.php">Tài khoản</a></li>
            <li><a href="../dangxuat.php" onclick="confirmLogout(event)">Đăng xuất</a></li>
        </ul>
    </div>
    </div>

