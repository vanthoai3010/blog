<?php
// Start session
session_start();

// Include database configuration file
include '../config/database.php';

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user'])) {
    // Nếu không, chuyển hướng người dùng về trang đăng nhập
    header("Location: ../views/client/login.php");
    exit();
}

// Kiểm tra nếu đã gửi form tạo bài viết
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"]) && isset($_POST['title']) && isset($_POST['content']) && isset($_POST['categories'])) {
    // Lấy dữ liệu từ form tạo bài viết
    $title = $_POST['title'];
    $content = $_POST['content'];
    $categories = $_POST['categories'];
    $author_id = $_POST['author_id'];
    $username = $_SESSION['user']['username']; // Lấy tên người dùng từ session

    // Xử lý tệp hình ảnh nếu có
    if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $uploadDir = '/mvc/public/client/img/user/';
        $destPath = $uploadDir . $fileName;

        // Di chuyển tệp hình ảnh vào thư mục lưu trữ
        if (move_uploaded_file($fileTmpPath, $_SERVER['DOCUMENT_ROOT'] . $destPath)) {
            // Thêm bài viết mới vào cơ sở dữ liệu
            $insertStmt = $db->prepare("INSERT INTO posts (title, content, hinh_anh, categories, create_by , author_id) VALUES (:title, :content, :hinh_anh, :categories, :create_by , :author_id)");
            $insertStmt->bindParam(':title', $title);
            $insertStmt->bindParam(':content', $content);
            $insertStmt->bindParam(':categories', $categories);
            $insertStmt->bindParam(':author_id', $author_id);
            $insertStmt->bindParam(':hinh_anh', $fileName); // Chỉ lưu tên tệp, không cần đường dẫn đầy đủ
            $insertStmt->bindParam(':create_by', $username); // Sử dụng username lấy từ session
            $insertStmt->execute();
            
            // Đăng bài viết thành công, chuyển hướng đến trang chính hoặc trang hiển thị bài viết mới
            $_SESSION['success'] = "Bài viết đã được đăng thành công.";
            header("Location: ../views/client/home.php");
            exit();
        } else {
            echo "Đã xảy ra lỗi khi di chuyển tệp hình ảnh.";
            exit();
        }
    } else {
        echo "Đã xảy ra lỗi khi tải lên tệp hình ảnh.";
        exit();
    }
} else {
    // Nếu không phải là phương thức POST hoặc dữ liệu POST không hợp lệ, chuyển hướng người dùng trở lại trang tạo bài viết
    header("Location: ../views/client/create_post.php");
    exit();
}
?>
