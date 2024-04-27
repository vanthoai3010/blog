<?php

// Trong EditController
session_start(); // Bắt đầu phiên session

// Kiểm tra xem session profile_post có tồn tại không và có dữ liệu không
if (isset($_SESSION['profile_post']) && !empty($_SESSION['profile_post'])) {
    $posts = $_SESSION['profile_post']; // Gán session vào biến $posts
} else {
    echo "không có bài viết";
    $posts = array(); // Nếu không có dữ liệu, gán $posts là một mảng rỗng
}

// Truyền dữ liệu vào View
require_once '/mvc/views/client/edit_post.php'; // Thay đổi đường dẫn đến file view của bạn
?>