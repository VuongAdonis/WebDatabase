<?php
// Kết nối đến cơ sở dữ liệu
require_once 'connection.php'; // Sử dụng connection.php

// Nhận UserID từ tham số URL
$userID = isset($_GET['userID']) ? $_GET['userID'] : 0;

// Truy vấn để lấy thông tin tiêu dùng của người dùng
$tsqlSpending = "SELECT dbo.GetTotalSpendingByUser($userID) AS TotalSpending;"; // Thay đổi tên bảng và cột nếu cần
$stmtSpending = sqlsrv_query($conn,$tsqlSpending);

$totalSpending = 0; // Khởi tạo biến tổng chi tiêu

if ($stmtSpending === false) {
    // Xử lý lỗi
    echo "Lỗi truy vấn: ";
    if ($errors = sqlsrv_errors()) {
        foreach ($errors as $error) {
            echo "Code: " . $error['code'] . ", Message: " . $error['message'] . "<br />";
        }
    }
} else {
    // Kiểm tra xem có sản phẩm nào được tìm thấy không
    if (sqlsrv_has_rows($stmtSpending)) {
        while ($row = sqlsrv_fetch_array($stmtSpending, SQLSRV_FETCH_ASSOC)) {
            $totalSpending = $row['TotalSpending']; // Lưu tổng chi tiêu
        }
    }
}

// Đóng kết nối
sqlsrv_free_stmt($stmtSpending);

?> 

<!-- Modal -->
<div id="spendingModal" style="display:block; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:1000;">
    <div style="background-color:white; margin:15% auto; padding:20px; width:80%; max-width:600px; border-radius:5px;">
        <h2>Thông tin tiêu dùng</h2>
        <p>Số tiền người dùng đã chi tiêu: <strong><?php echo number_format($totalSpending, 2); ?> VNĐ</strong></p>
        <button onclick="closeModal()">Close</button>
    </div>
</div>

<script>
function closeModal() {
    window.history.back();
}
</script>