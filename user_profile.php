<?php
session_start(); // Bắt đầu phiên làm việc
require_once 'connection.php'; // Sử dụng connection.php

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php"); // Chuyển hướng về trang đăng nhập nếu chưa đăng nhập
    exit();
}

// Lấy thông tin người dùng từ cơ sở dữ liệu
$user_id = $_SESSION['user_id']; // Giả sử bạn đã lưu user_id trong session khi đăng nhập
$tsql = "SELECT UserID, LName, FName, Email, DateOfBirth, CreatedTime, UpdatedTime, UserType, isActive FROM users WHERE UserID = '$user_id'";
$stmt = sqlsrv_query($conn,$tsql);

if ($obj = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    // $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $user = $obj;
}

// $stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <style>
        /* Thêm một số kiểu cơ bản */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .profile-info {
            margin-bottom: 20px;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>User Profile</h1>
    <div class="profile-info">
        <p><strong>User ID:</strong> <?php echo $user['UserID']; ?></p>
        <p><strong>Full Name:</strong> <?php echo $user['LName'] . ' ' . $user['FName']; ?></p>
        <p><strong>Email:</strong> <?php echo $user['Email']; ?></p>
        <p><strong>Date of Birth:</strong> <?php echo $user['DateOfBirth']->format('Y-m-d'); ?></p>
        <p><strong>Created Time:</strong> <?php echo $user['CreatedTime']->format('Y-m-d'); ?></p>
        <p><strong>Updated Time:</strong> <?php echo $user['UpdatedTime']->format('Y-m-d'); ?></p>
        <p><strong>User Type:</strong> <?php echo $user['UserType']; ?></p>
        <p><strong>Active:</strong> <?php echo $user['isActive'] ? 'Yes' : 'No'; ?></p>
    </div>
    <a href="edit_profile.php" class="btn">Edit Profile</a>
</body>
</html> 