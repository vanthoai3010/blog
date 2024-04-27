<?php
session_start();
include '../config/database.php';

// Kiểm tra nếu người dùng đã đăng nhập và có session 'user'
if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user']['user_id']; // Giả sử user_id được lưu trong session 'user'

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post_id'])) {
        $post_id = $_POST['post_id'];

        try {
            // Kiểm tra xem post_id đã tồn tại cho người dùng hiện tại chưa
            $sql_check = "SELECT COUNT(*) AS count FROM saved_posts WHERE user_id = :user_id AND post_id = :post_id";
            $stmt_check = $db->prepare($sql_check);
            $stmt_check->bindParam(':user_id', $user_id);
            $stmt_check->bindParam(':post_id', $post_id);
            $stmt_check->execute();
            $row = $stmt_check->fetch(PDO::FETCH_ASSOC);

            if ($row['count'] == 0) {
                // Nếu post_id chưa tồn tại, thực hiện insert dữ liệu vào bảng lưu bài viết
                $sql_insert = "INSERT INTO saved_posts (user_id, post_id) VALUES (:user_id, :post_id)";
                $stmt_insert = $db->prepare($sql_insert);
                $stmt_insert->bindParam(':user_id', $user_id);
                $stmt_insert->bindParam(':post_id', $post_id);
                $stmt_insert->execute();

                echo "Bài viết đã được lưu thành công.";
            } else {
                echo "Bài viết đã tồn tại trong danh sách lưu của bạn.";
            }
        } catch (PDOException $e) {
            // Xử lý lỗi nếu có lỗi khi thực hiện truy vấn
            echo "Lỗi: " . $e->getMessage();
        }
    }
} else {
    echo "Bạn cần đăng nhập để lưu bài viết.";
}
?>
