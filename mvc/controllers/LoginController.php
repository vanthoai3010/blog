<?php
session_start();
// Include file cấu hình cơ sở dữ liệu
include '../config/database.php';
// Kiểm tra xem đã submit form đăng nhập hay chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form đăng nhập
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Truy vấn cơ sở dữ liệu để kiểm tra thông tin đăng nhập
    $stmt = $db->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Kiểm tra xem có dữ liệu trả về từ cơ sở dữ liệu hay không
    if ($user) {
        // Lưu thông tin người dùng vào session
        $_SESSION['user'] = $user;
        $_SESSION['user_id'] = $user['user_id']; // Giả sử user_id là cột trong bảng users

        // Kiểm tra nếu là admin
        if ($user['role'] == 1) {
            // Đăng nhập thành công và là admin, chuyển hướng đến trang admin
            header("Location: ../views/admin/admin.php");
            exit();
        } else {
            // Đăng nhập thành công, không phải là admin, chuyển hướng đến trang chính
            $_SESSION['success_message'] = true;
            header("Location: ../views/client/home.php");
            exit();
        }
    } else {
        // Đăng nhập thất bại, chuyển hướng người dùng trở lại trang đăng nhập và hiển thị thông báo lỗi
        header("Location: ../views/client/login.php?error=1");
        exit();
    }
}

// Kiểm tra nếu người dùng muốn đăng xuất
if (isset($_GET['logout'])) {
    // Xóa toàn bộ session
    session_unset();
    // Hủy session
    session_destroy();
    // Chuyển hướng người dùng về trang đăng nhập
    header("Location: ../views/client/login.php");
    exit();
}
