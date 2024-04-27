<?php
session_start();
include __DIR__ . '/../../config/database.php';
// edit posts admin
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $post_id = $_POST['post_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $categories = $_POST['categories'];

    // Xử lý upload hình ảnh nếu có
    if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $uploadDir = '/mvc/public/client/img/user/';
        $destPath = $uploadDir . $fileName;

        // Di chuyển tệp hình ảnh vào thư mục lưu trữ
        if (move_uploaded_file($fileTmpPath, $_SERVER['DOCUMENT_ROOT'] . $destPath)) {
            // Cập nhật thông tin bài viết trong cơ sở dữ liệu
            $sql = "UPDATE posts SET title=?, content=?, hinh_anh=?, categories=? WHERE post_id=?";
            $stmt = $db->prepare($sql);
            if ($stmt) {
                $stmt->bindParam(1, $title);
                $stmt->bindParam(2, $content);
                $stmt->bindParam(3, $fileName); // Chỉ lưu tên tệp, không cần đường dẫn đầy đủ
                $stmt->bindParam(4, $categories);
                $stmt->bindParam(5, $post_id);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    echo "success";
                } else {
                   //
                }
            } else {
                echo "Lỗi: Không thể chuẩn bị câu lệnh truy vấn.";
            }
        } else {
            echo "Đã xảy ra lỗi khi di chuyển tệp hình ảnh.";
            exit();
        }
    } else {
        echo "Đã xảy ra lỗi khi tải lên tệp hình ảnh.";
        exit();
    }
} else {
    // Xử lý lỗi khi không phải là phương thức POST
    echo "Lỗi: Yêu cầu không hợp lệ.";
}

?>
