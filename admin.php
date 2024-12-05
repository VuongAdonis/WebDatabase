<?php
session_start(); // Bắt đầu phiên làm việc

// Kiểm tra nếu người dùng chọn "Exit"
if (isset($_POST['OUT'])) {
    session_destroy(); // Xóa tất cả các biến session
    header("Location: web.php"); // Chuyển hướng về trang đăng nhập
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .toolbar {
            background-color: #333;
            overflow: hidden;
        }
        .toolbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .toolbar a:hover {
            background-color: #ddd;
            color: black;
        }
    </style>
</head>
<body>
    <div class="toolbar">
        <a href="adminUser.php">User</a> <!-- Thêm liên kết đến adminUser.php -->
        <a href="store.php">Store</a>
        <a href="product.php">Product</a>
        <form method="POST" action="" style="margin: 0;">
        <button type="submit" name="OUT" style="display: flex; justify-content: flex-end;margin-top: 15px;">OUT</button>
        </form>
    </div>

    <h1>Chào mừng đến với trang quản trị!</h1>
    <p>Chọn một trong các tùy chọn trên thanh công cụ để quản lý.</p>

    
    <!-- Nội dung khác của trang admin -->
</body>
</html> 