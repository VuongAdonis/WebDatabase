<?php
// Kết nối đến cơ sở dữ liệu
session_start(); // Bắt đầu phiên làm việc
require_once 'connection.php'; // Sử dụng connection.php

// Xử lý khi người dùng gửi form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_button'])) {
    $email = $_POST['email'];
    $lname = $_POST['lname'];
    $fname = $_POST['fname'];
    $dob = $_POST['dob'];
    $password = $_POST['password'];
    $userId = $_POST['user_id']; // ID người dùng để cập nhật

    // Câu lệnh UPDATE
    $tsql2 = "EXEC UpdateUser
    @UserID = '$userId',
    @LName = '$lname',
    @FName = '$fname',
    @Email = '$email',
    @PasswordUser = '$password',
    @DateOfBirth = '$dob',
    @UserType = '0',
    @isActive = '1';";
    $stmt2 = sqlsrv_query($conn,$tsql2);

    if($stmt2 == false){
        echo "Lỗi update: ";
        if ($errors = sqlsrv_errors()) {
            $errorMessage = "Lỗi update: ";
            foreach ($errors as $error) {
                $errorMessage .= "Code: " . $error['code'] . ", Message: " . $error['message'] . "\\n";
            }
            echo "<script>
                    alert('" . addslashes($errorMessage) . "');
                    window.location.href = 'edit_profile.php';
                  </script>";
        }
    }
    else {
        echo "<script>
            alert('Cập nhật thành công!');
          </script>";
    }
    // header("Location: edit_profile.php");
    // exit();
    // $stmt2->close();
}
// Lấy thông tin người dùng hiện tại (giả sử bạn đã có ID người dùng)
$user_id = $_GET['userID']; // Giả sử bạn đã lưu user_id trong session khi đăng nhập
$tsql = "SELECT UserID, LName, FName, Email, PasswordUser, DateOfBirth, CreatedTime, UpdatedTime, UserType, isActive FROM users WHERE UserID = '$user_id'";
$stmt = sqlsrv_query($conn,$tsql);
if ($obj = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    // $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $user = $obj;
}


// $stmt->close();  


?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa thông tin cá nhân</title>
    <style>
        .back-button {
            position: absolute;
            top: 10px;
            left: 10px;
            margin-bottom: 20px; /* Tạo khoảng cách dưới nút */
        }
        h2 {
            margin-top: 50px; /* Tạo khoảng cách trên tiêu đề */
        }
        .grayed-out {
            background-color: #f0f0f0; /* Light gray background */
            color: #a0a0a0; /* Gray text */
            border: 1px solid #d0d0d0; /* Light gray border */
            cursor: not-allowed; /* Change cursor to indicate it's not editable */
        }
    </style>
</head>
<body>
    <a href="adminUser.php" class="back-button"><button>Quay lại trangAdmin</button></a> <!-- Nút quay lại -->

    <h2>Chỉnh sửa thông tin cá nhân</h2>
    <form method="post" action="">
        <input type="hidden" name="user_id" value="<?php echo $user['UserID']; ?>">
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>" required readonly><br>
        
        <label for="lname">Họ:</label>
        <input type="text" name="lname" value="<?php echo htmlspecialchars($user['LName']); ?>" required><br>
        
        <label for="fname">Tên:</label>
        <input type="text" name="fname" value="<?php echo htmlspecialchars($user['FName']); ?>" required><br>
        
        <label for="dob">Ngày sinh:</label>
        <input type="date" name="dob" value="<?php echo htmlspecialchars($user['DateOfBirth']->format('Y-m-d')); ?>" required><br>

        <label for="userType">Loại người dùng:</label>
        <input type="text" name="userType" value="<?php echo htmlspecialchars($user['UserType']); ?>"  class="grayed-out" readonly><br> <!-- Không cho phép thay đổi -->
        
        <label for="password">Mật khẩu mới:</label>
        <input type="password" name="password" value="<?php echo htmlspecialchars($user['PasswordUser']); ?>" required><br>
        
        <input type="submit" name="update_button" value="Cập nhật">
        <input type="submit" name="delete" value="Xóa tài khoản" onclick="return confirmDelete();">
    </form> 

    <script>
    function confirmDelete() {
        return confirm('Bạn có chắc chắn muốn xóa tài khoản này không?');
    }
    </script>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
        // Thực hiện truy vấn xóa tài khoản trong cơ sở dữ liệu
        $userId = $_POST['user_id']; // ID người dùng để cập nhật

        $tsql3 = "EXEC DeleteUser
            @UserID = $userId";

        $stmt3 = sqlsrv_query($conn,$tsql3);

        if($stmt3 == false){
            echo "Lỗi delete: ";
            if ($errors = sqlsrv_errors()) {
                $errorMessage = "Lỗi xóa tài khoản: ";
                foreach ($errors as $error) {
                    $errorMessage .= "Code: " . $error['code'] . ", Message: " . $error['message'] . "\\n";
                }
                echo "<script>alert('" . addslashes($errorMessage) . "');</script>";
            }
        } else {
            // Thành công, hiển thị thông báo pop-up và đăng xuất người dùng
            echo "<script>
                    alert('Xóa tài khoản thành công! Bạn sẽ được đăng xuất.');
                    window.location.href = 'adminUser.php'; // Chuyển hướng về admin
                  </script>";

            // Hủy phiên người dùng
            // session_start(); // Bắt đầu phiên nếu chưa bắt đầu
            // session_unset(); // Xóa tất cả các biến phiên
            // session_destroy(); // Hủy phiên
            exit(); // Dừng thực thi mã sau khi chuyển hướng
        }
    }
    ?>
</body>
</html> 