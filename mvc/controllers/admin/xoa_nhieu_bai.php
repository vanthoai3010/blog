<?php
session_start();
include __DIR__ . '/../../config/database.php';

// Kiểm tra xem yêu cầu POST chứa danh sách các ID bài viết được chọn không
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selectedPosts'])) {
    // Lấy danh sách các ID bài viết được chọn từ yêu cầu POST
    $selectedPosts = $_POST['selectedPosts'];

    try {
        // Tạo chuỗi placeholders '?' dùng cho câu truy vấn SQL
        $placeholders = str_repeat('?,', count($selectedPosts) - 1) . '?';

        // Chuẩn bị câu truy vấn SQL DELETE với điều kiện IN
        $sql = "DELETE FROM posts WHERE post_id IN ($placeholders)";
        $stmt = $db->prepare($sql);

        // Gắn các giá trị ID bài viết vào câu truy vấn
        $stmt->execute($selectedPosts);

        // Kiểm tra số lượng bản ghi bị ảnh hưởng và trả về kết quả cho client
        if ($stmt->rowCount() > 0) {
            echo "success";
        } else {
            echo "error";
        }
    } catch(PDOException $e) {
        // Xử lý lỗi nếu có
        echo "Lỗi khi thực hiện truy vấn: " . $e->getMessage();
    }
} else {
    // Trả về thông báo lỗi nếu không có danh sách các ID bài viết được chọn
    echo "error";
}
?>
