<?php
session_start();
include __DIR__ . '/../../config/database.php';

// Kiểm tra xem yêu cầu là phương thức POST và có tồn tại post_id không
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post_id'])) {
    // Lấy ID của danh mục từ dữ liệu gửi đi
    $post_id = $_POST['post_id'];

    try {
        $query = "DELETE FROM posts WHERE post_id = :post_id";

        // Chuẩn bị và thực thi truy vấn
        $statement = $db->prepare($query);
        $statement->execute(array(':post_id' => $post_id));
        echo "success";
        exit();
    } catch (PDOException $e) {
        echo "Lỗi xóa danh mục: " . $e->getMessage();
    }
} else {
    echo "Không có dữ liệu hợp lệ được gửi đi để xóa.";
}
