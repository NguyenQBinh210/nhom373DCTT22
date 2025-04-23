
<?php
// Bắt đầu session
session_start();

// Xóa tất cả session
session_unset();

// Hủy session
session_destroy();

// Chuyển hướng về trang đăng nhập
header("Location: /Php_web/login.php");
exit();
?>
