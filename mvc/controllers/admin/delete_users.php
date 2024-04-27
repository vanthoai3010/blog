<?php 

session_start();
include __DIR__ . '/../../config/database.php';

// Kiểm tra xem yêu cầu là phương thức POST và có tồn tại user_id không
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    // Lấy ID của danh mục từ dữ liệu gửi đi
    $user_id = $_POST['user_id'];

    try {
        $query = "DELETE FROM users WHERE user_id = :user_id";

        // Chuẩn bị và thực thi truy vấn
        $statement = $db->prepare($query);
        $statement->execute(array(':user_id' => $user_id));
        echo "success";
        exit();
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
} else {
    echo "Không có dữ liệu hợp lệ được gửi đi để xóa.";
}


?>