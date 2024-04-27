<?php
session_start();
include __DIR__ . '/../../config/database.php';

// Kiểm tra xem yêu cầu là phương thức POST và có tồn tại post_id không
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['category_id'])) {
    // Lấy ID của danh mục từ dữ liệu gửi đi
    $category_id = $_POST['category_id'];

    try {
        $query = "DELETE FROM categories WHERE category_id = :category_id";

        // Chuẩn bị và thực thi truy vấn
        $statement = $db->prepare($query);
        $statement->execute(array(':category_id' => $category_id));
        echo "success";
        exit();
    } catch (PDOException $e) {
        echo "Lỗi xóa danh mục: " . $e->getMessage();
    }
} else {
    echo "Không có dữ liệu hợp lệ được gửi đi để xóa.";
}
