<?php
session_start();
include '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem người dùng đã đăng nhập hay chưa
    if (!isset($_SESSION['user'])) {
        header("Location: /mvc/views/client/login.php");
        exit();
    }

    // Lấy dữ liệu bình luận từ form
    $commentContent = $_POST['comment'];
    // Lấy ID người dùng từ session
    $userId = $_SESSION['user']['user_id'];
    $username = $_SESSION['user']['username'];
    $postId = $_SESSION['post_id'];

    // Thêm bình luận vào bảng comments
    $statement = $db->prepare("INSERT INTO comments (content, user_id, username, post_id) VALUES (?, ?, ?, ?)");
    $statement->execute([$commentContent, $userId, $username, $postId]);

    // Chuyển hướng người dùng đến trang post.php
    echo "success";
    exit();
} else {
    // Nếu không phải là phương thức POST, chuyển hướng người dùng đến trang khác hoặc xử lý lỗi
    header("Location: /some/error/page.php");
    exit();
}
