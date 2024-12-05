<?php
require_once 'connection.php'; // Kết nối đến cơ sở dữ liệu

if (isset($_GET['userID'])) {
    $userID = $_GET['userID'];

    // Thực hiện truy vấn xóa tài khoản trong cơ sở dữ liệu

    $tsql3 = "EXEC DeleteUser
        @UserID = '$userID'";

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
                alert('Xóa tài khoản thành công! quay trở lại trang admin.');
                window.location.href = 'adminUser.php'; // Chuyển hướng về trang admin
                </script>";
    }
}
// // Đóng kết nối
sqlsrv_close($conn);
?>
