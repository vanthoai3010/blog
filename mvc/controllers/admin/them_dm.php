<?php
session_start();
include __DIR__ . '/../../config/database.php';

// Kiểm tra xem yêu cầu là phương thức POST và có tồn tại add_dm không
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_dm'])) {
    // Lấy tên danh mục từ dữ liệu gửi đi
    $name = $_POST['add_dm'];

    try {
        // Chuẩn bị truy vấn INSERT
        $query = "INSERT INTO categories (name) VALUES (:name)";

        // Chuẩn bị và thực thi truy vấn
        $statement = $db->prepare($query);
        $statement->execute(array(':name' => $name));

        // Trả về thành công
        echo "success";
        exit();
    } catch (PDOException $e) {
        // Bắt lỗi nếu có
        echo "Lỗi thêm danh mục: " . $e->getMessage();
    }
} else {
    echo "Không có dữ liệu hợp lệ được gửi đi để thêm.";
}
?>
