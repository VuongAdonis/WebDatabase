<?php
// Kết nối đến cơ sở dữ liệu
require_once 'connection.php'; // Sử dụng connection.php

// Kết nối đến cơ sở dữ liệu


// Nhận truy vấn tìm kiếm từ biểu mẫu
$query = isset($_GET['query']) ? $_GET['query'] : '';
$storeID = isset($_GET['storeID']) ? $_GET['storeID'] : '';
$min_price = isset($_GET['minPrice']) ? $_GET['minPrice'] : 0;
$max_price = isset($_GET['maxPrice']) ? $_GET['maxPrice'] : 1000000;
$minQuantity = isset($_GET['minQuantity']) ? $_GET['minQuantity'] : 0;
$order = "";
// if ($sortOrder === 'asc') {
//     $order = "1";
// } elseif ($sortOrder === 'desc') {
//     $order = "0";
// }
if (isset($_GET['sort'])) {
    $sortOrder = $_GET['sort']; 
    if($sortOrder === 'asc')
    {
        $order = 0;
    }
    else{
        $order = 1;
    }
}

$tsqlProduct = "EXEC GetProductsByPriceOfStore @min_price = '$min_price', @max_price = '$max_price', @store_id = '$storeID', @OrderBy = '$order'"; // Thay đổi tên bảng nếu cần

$stmtProduct = sqlsrv_query($conn,$tsqlProduct);

if ($stmtProduct === false) {
    // Xử lý lỗi
    echo "Lỗi truy vấn: ";
    if ($errors = sqlsrv_errors()) {
        foreach ($errors as $error) {
            echo "Code: " . $error['code'] . ", Message: " . $error['message'] . "<br />";
        }
    }
} else {
    // Hiển thị kết quả tìm kiếm
    echo '<button onclick="window.location.href=`web.php`;">Quay lại</button>';

    echo '<form method="GET" action="">
            <div>
                <label for="storeID">Store ID:</label><br>
                <input type="number" id="storeID" name="storeID" placeholder="storeID" min="1" required />
            </div>

            <div>
                <label for="minQuantity">Min Quantity:</label><br>
                <input type="number" id="minQuantity" name="minQuantity" placeholder="Min Quantity" min="1" />
            </div>

            <div>
                <label for="minPrice">Min Price:</label><br>
                <input type="number" id="minPrice" name="minPrice" placeholder="Min Price" min="0" step="0.01" />
            </div>

            <div>
                <label for="maxPrice">Max Price:</label><br>
                <input type="number" id="maxPrice" name="maxPrice" placeholder="Max Price" min="0" step="0.01" />
            </div>

            <button type="submit">Search</button>
            
            <!-- Sort buttons for Price -->
            <div style="margin-top: 10px;">
                <label>
                    <input type="radio" name="sort" value="asc" checked/> ↑ Sort by Price Ascending
                </label><br>
                <label>
                    <input type="radio" name="sort" value="desc" /> ↓ Sort by Price Descending
                </label>
            </div>
          </form>';

    echo "<h1>Kết quả tìm kiếm cho: " . htmlspecialchars($query) . "</h1>";
    echo "<table border='1' style='width: 100%; border-collapse: collapse;'>
            <tr>
                <th>ProductID</th>
                <th>ProductName</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>CategoryName</th>
            </tr>";

    // Kiểm tra xem có sản phẩm nào được tìm thấy không
    if (sqlsrv_has_rows($stmtProduct)) {
        while ($row = sqlsrv_fetch_array($stmtProduct, SQLSRV_FETCH_ASSOC)) {
            echo "<tr>
                    <td>" . $row['ProductID'] . "</td>
                    <td>" . $row['Name'] . "</td>
                    <td>" . number_format($row['Price'], 2) . "</td>
                    <td>" . $row['Quantity'] . "</td>
                    <td>" . $row['CategoryName'] . "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>Không tìm thấy sản phẩm nào.</td></tr>";
    }

    echo "</table>";
}

// Đóng kết nối
sqlsrv_free_stmt($stmtProduct);
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sort Products</title>
    <style>
        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .add-product {
            margin-left: auto; /* Đẩy nút sang bên phải */
        }
    </style>
</head>
<body>

<div class="container">
    <button class="add-product">Thêm sản phẩm</button>
</div>

</body>
</html>