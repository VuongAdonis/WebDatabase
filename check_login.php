<?php
session_start();
require_once 'connection.php'; // Sử dụng connection.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Thông báo nhận được yêu cầu
    error_log("Received login request"); // Ghi vào log của server

    $email = $_POST['email']; // Lấy giá trị email từ form
    $password = $_POST['password']; // Lấy giá trị password từ form

    try {
        // $stmt = $conn->prepare("SELECT * FROM USERS WHERE Email = ? AND PasswordUser = ?");
        // $stmt->execute([$email, $password]);
        // $tsql = "SELECT * FROM USERS WHERE Email = $email AND PasswordUser = $password";
        $tsql4 = "SELECT * FROM USERS WHERE Email = '$email' AND PasswordUser = '$password'";
        $stmt4 = sqlsrv_query($conn,$tsql4);
        if($stmt4 == false)
        {
            echo $email;
            echo $password;
            echo $tsql;
            $errorInfo = $pdo->errorInfo();
            echo 'Error: ' . $errorInfo[2]; // In ra thông báo lỗi
        }
        if ($obj = sqlsrv_fetch_array($stmt4, SQLSRV_FETCH_ASSOC)) {
            // $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['user_id'] = $obj['UserID'];
            $_SESSION['user_name'] = $obj['FName'];
            $_SESSION['user_email'] = $obj['Email'];
            $_SESSION['user_password'] = $obj['PasswordUser'];
            $_SESSION['user_type'] = $obj['UserType'];
            $_SESSION['user_isActive'] = $obj['isActive'];
            
            // Kiểm tra xem email có phải là admin không
            if ($obj['Email'] === 'admin@gmail.com') { // Thay đổi email admin theo yêu cầu
                // Chuyển hướng đến trang admin
                echo json_encode([
                    'success' => true,
                    'isAdmin' => 1,
                    'isUser' => 0
                ]);
                exit();
            } else {
                // Chuyển hướng đến trang người dùng thông thường
                echo json_encode([
                    'success' => true,
                    'isAdmin' => 0,
                    'isUser' => 1
                ]);
                exit();
            }
        } else {
            echo json_encode(["success" => false, "message" => "Invalid email or password"]);
        }
    } catch(PDOException $e) {
        echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
    }
}
?> 