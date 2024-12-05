<?php
// Kết nối đến cơ sở dữ 
require_once 'connection.php'; // Sử dụng connection.php

// Truy vấn để lấy dữ liệu từ bảng User
$tsqlUser = "SELECT * FROM Users";
$stmtUser = sqlsrv_query($conn,$tsqlUser);

if ($stmtUser === false) {
    // Xử lý lỗi
    echo "Lỗi truy vấn: ";
    if ($errors = sqlsrv_errors()) {
        foreach ($errors as $error) {
            echo "Code: " . $error['code'] . ", Message: " . $error['message'] . "<br />";
        }
    }
} else {
    // Hiển thị dữ liệu
    echo "<a href='admin.php'>
            <button style='margin-bottom: 10px;'>Back to Admin</button>
          </a>";

    echo "<h1>Danh sách người dùng</h1>";

    echo "<form method='POST' action='adminAddUser.php'>
    <button style='margin-bottom: 10px;'>Thêm User</button>
    </form>";

    echo "<table border='1' style='width: 100%; border-collapse: collapse;'>
            <tr style='background-color: #f2f2f2;'>
                <th>UserID</th>
                <th>Họ</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Ngày Sinh</th>
                <th>Loại Người Dùng</th>
                <th>Trạng Thái</th> <!-- Thêm cột Trạng Thái -->
                <th>Hành Động</th> <!-- Thêm cột Hành Động -->
            </tr>";

    while ($row = sqlsrv_fetch_array($stmtUser, SQLSRV_FETCH_ASSOC)) {
        echo "<tr>
                <td>" . $row['UserID'] . "</td>
                <td>" . $row['LName'] . "</td>
                <td>" . $row['FName'] . "</td>
                <td>" . $row['Email'] . "</td>
                <td>" . ($row['DateOfBirth'] ? $row['DateOfBirth']->format('Y-m-d') : 'N/A') . "</td>
                <td>" . ($row['UserType'] == 1 ? 'Admin' : 'User') . "</td>
                 <td>" . ($row['isActive'] ? 'Kích hoạt' : 'Không kích hoạt') . "</td> <!-- Hiển thị trạng thái -->
                <td>
                    <a href='editUser.php?userID=" . $row['UserID'] . "'>
                        <button>Edit</button>
                    </a>
                    <a href='deleteUser.php?userID=" . $row['UserID'] . "' onclick='return confirm(\"Bạn có chắc chắn muốn xóa người dùng này không?\");'>
                        <button style='background-color: red; color: white;'>Delete</button>
                    </a>
                    <a href='checkSpending.php?userID=" . $row['UserID'] . "'>
                        <button>Check Spending</button>
                    </a>
                </td>
              </tr>";
    }

    echo "</table>";
}

// Đóng kết nối
sqlsrv_free_stmt($stmtUser);
?> 