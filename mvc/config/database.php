<?php

// Thông tin kết nối đến cơ sở dữ liệu
$host = 'localhost'; 
$dbname = 'blog'; 
$username = 'root'; 
$password = ''; 

try {
    // Tạo kết nối đến cơ sở dữ liệu
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Thiết lập chế độ báo lỗi để hiển thị các thông báo lỗi của MySQL
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Thiết lập bộ mã kết nối
    $db->exec("set names utf8");
} catch(PDOException $e) {
    // Xử lý lỗi nếu kết nối không thành công
    echo "Lỗi kết nối: " . $e->getMessage();
    die(); // Dừng script
}
