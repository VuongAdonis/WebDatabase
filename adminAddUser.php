<?php
require_once 'connection.php'; // Sử dụng connection.php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addUser'])){
// Nhận dữ liệu từ biểu mẫu
$lname = $_POST['LName'];
$fname = $_POST['FName'];
$email = $_POST['Email'];
$password = $_POST['PasswordUser'];
$dob = $_POST['DateOfBirth'];
$usertype = $_POST['UserType'];

// Truy vấn để chèn dữ liệu
$tsqlid = "select MAX(UserID)+1 AS COUNT from USERS ";
$stmtid = sqlsrv_query($conn,$tsqlid);

if($stmtid == false)
{
    echo 'Error';
}

while($obj = sqlsrv_fetch_array($stmtid, SQLSRV_FETCH_ASSOC))
{
    $countValue = $obj['COUNT'];
}
echo $countValue;
sqlsrv_free_stmt($stmtid);

$tsql = "EXEC InsertUser 
    @UserID = $countValue, 
    @LName = '$lname', 
    @FName = '$fname', 
    @Email = '$email', 
    @PasswordUser = '$password', 
    @DateOfBirth = '$dob',  
    @UserType = $usertype, 
    @isActive = 1, 
    @ReferID = NULL, 
    @TimeStart = NULL";

$stmt3 = sqlsrv_query($conn,$tsql);

if ($stmt3 === false) {
    // Xử lý lỗi khi không thể chèn dữ liệu
    echo "Lỗi đăng ký: ";
    if ($errors = sqlsrv_errors()) {
        $errorMessage = "Lỗi đăng ký tài khoản: ";
        foreach ($errors as $error) {
            $errorMessage .= "Code: " . $error['code'] . ", Message: " . $error['message'] . "\\n";
        }
        echo "<script>alert('" . addslashes($errorMessage) . "');</script>";
    }
} else {

    // Thành công, hiển thị thông báo pop-up và chuyển hướng về admin
    
    echo "<script>
            alert('Tạo tài khoản thành công! Bạn sẽ được chuyển hướng về trang admin.');
            window.location.href = 'adminUser.php'; // Chuyển hướng về admin
          </script>";
}
}
?> 

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
</head>
<body>
    <h2>Đăng Ký Tài Khoản</h2>
    <form method="POST" action="adminAddUser.php"> <!-- Thay đổi action nếu cần -->
        <label for="lname">Họ:</label>
        <input type="text" id="lname" name="LName" required><br><br>

        <label for="fname">Tên:</label>
        <input type="text" id="fname" name="FName" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="Email" required><br><br>

        <label for="password">Mật Khẩu:</label>
        <input type="password" id="password" name="PasswordUser" required><br><br>

        <label for="dob">Ngày Sinh:</label>
        <input type="date" id="dob" name="DateOfBirth" required><br><br>

        <label for="usertype">Loại Người Dùng:</label>
        <select id="usertype" name="UserType" required>
            <option value="0">Người Dùng Thường</option>
            <option value="1">Quản Trị Viên</option>
        </select><br><br>

        <input type="submit" name="addUser" value="Đăng Ký">
    </form>
</body>
</html> 