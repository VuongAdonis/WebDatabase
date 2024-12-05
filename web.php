<?php
session_start(); // Bắt đầu phiên làm việc

// Kiểm tra nếu người dùng chọn "Exit"
if (isset($_POST['exit'])) {
    session_destroy(); // Xóa tất cả các biến session
    header("Location: login.html"); // Chuyển hướng về trang đăng nhập
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website with Toolbar</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .toolbar {
            background-color: #333;
            overflow: hidden;
            padding: 10px 20px;
        }

        .toolbar a {
            float: left;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        .toolbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .toolbar a.active {
            background-color: #4CAF50;
            color: white;
        }

        .content {
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        .form-container {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
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

        .search-toolbar {
            margin: 20px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }

        .search-toolbar form {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .search-toolbar input,
        .search-toolbar select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            flex: 1;
            min-width: 150px;
        }

        .search-toolbar .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }

        .search-toolbar .btn:hover {
            background-color: #45a049;
        }

        .featured-products {
            margin-top: 40px;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 5px;
        }

        .featured-products h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .product-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .product-item {
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
            width: 200px;
            text-align: center;
        }

        .product-item h3 {
            margin-bottom: 10px;
            color: #4CAF50;
        }

        .product-item p {
            margin: 5px 0;
            color: #555;
        }

        .product-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .product-item {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .product-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            cursor: pointer;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1000;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a, .dropdown-content button {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            border: none;
            background: none;
            cursor: pointer;
            width: 100%;
            box-sizing: border-box;
        }

        .dropdown-content a:hover, .dropdown-content button:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="toolbar">
        <a class="active" href="web.php">Home</a>
        <a href="myorder.php">MyOrder</a>
        <a href="mycart.php">MyCart</a>
        <a href="mystore.php">MyStore</a>
        
        <?php if (isset($_SESSION['user_name'])): ?>
            <div class="dropdown" style="float: right;">
                <a href="#"><?php echo $_SESSION['user_name']; ?></a>
                <div class="dropdown-content">
                    <form method="POST" action="" style="margin: 0;">
                        <button type="submit" name="exit">Exit</button>
                    </form>
                    <a href="user_profile.php">User Profile</a>
                </div>
            </div>
        <?php else: ?>
            <a href="login.html" style="float: right;">Login</a>
            <a href="register.php" style="float: right;">Register</a>
        <?php endif; ?>
    </div>

    <div class="content">
        <!-- Add this search toolbar -->
        <div class="search-toolbar">
            <form action="search.php" method="GET">
                <div>
                    <label for="storeID">Store ID:</label>
                    <input type="number" name="storeID" placeholder="storeID" min="1" required />
                </div>
                <div>
                    <label for="minQuantity">Min Quantity:</label>
                    <input type="number" name="minQuantity" placeholder="Min Quantity" min="1 " />
                </div>
                <div>
                    <label for="minPrice">Min Price:</label>
                    <input type="number" name="minPrice" placeholder="Min Price" min="0" step="0.01" />
                </div>
                <div>
                <label for="maxPrice">Max Price:</label>
                <input type="number" name="maxPrice" placeholder="Max Price" min="0" step="0.01" />
                </div>
                <button type="submit" class="btn">Search</button>
            </form>
        </div>
        </div>
    </div>
</body>
</html>
