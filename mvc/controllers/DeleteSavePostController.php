<?php
session_start();
include '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user']['user_id'];

    // Truy vấn xóa bài viết đã lưu từ bảng saved_posts
    $sql_delete_saved_post = "DELETE FROM saved_posts WHERE user_id = ? AND post_id = ?";
    $stmt_delete_saved_post = $conn->prepare($sql_delete_saved_post);
    $stmt_delete_saved_post->bind_param("ii", $user_id, $post_id);

    if ($stmt_delete_saved_post->execute()) {
        // Trả về kết quả thành công nếu xóa thành công
        echo "Xóa bài viết thành công!";
    } else {
        // Trả về thông báo lỗi nếu có lỗi xảy ra
        echo "Lỗi: " . $conn->error;
    }

    $stmt_delete_saved_post->close();
    $conn->close();
} else {
    // Trả về thông báo lỗi nếu yêu cầu không hợp lệ
    echo "Yêu cầu không hợp lệ!";
}
?>
