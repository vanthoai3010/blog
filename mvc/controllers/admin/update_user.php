<?php
session_start();
include __DIR__ . '/../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];
    $email = $_POST["email"];

    try {
        // Truy vấn SQL với binding tham số
        $query = "UPDATE users SET email = :email WHERE user_id = :user_id";

        // Chuẩn bị và thực thi truy vấn với binding tham số
        $statement = $db->prepare($query);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->execute();

        // Trả về kết quả thành công
        echo "success";
        exit();
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
} else {
    echo "Không có dữ liệu hợp lệ được gửi đi để cập nhật.";
}
?>
