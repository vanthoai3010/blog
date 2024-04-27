<?php
// Start session
session_start();

// Include database configuration file
include '../config/database.php';

// Kiểm tra nếu đã gửi form đăng ký
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form đăng ký
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $diachi = $_POST["diachi"];

    // Kiểm tra tính hợp lệ của dữ liệu
    if (!empty($username) && !empty($email) && !empty($password)) {
        // Kiểm tra xem người dùng đã tồn tại trong cơ sở dữ liệu chưa
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$existingUser) {
            // Mã hóa mật khẩu
            // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Thêm người dùng mới vào cơ sở dữ liệu
            $insertStmt = $db->prepare("INSERT INTO users (username, email, phone, password, diachi) VALUES (:username, :email, :phone, :password, :diachi)");
            $insertStmt->bindParam(':username', $username);
            $insertStmt->bindParam(':email', $email);
            $insertStmt->bindParam(':phone', $phone); // Thêm trường dữ liệu phone
            $insertStmt->bindParam(':password', $password);
            $insertStmt->bindParam(':diachi', $diachi); // Thêm trường dữ liệu diachi
            $insertStmt->execute();


            // Đăng ký thành công, chuyển hướng người dùng đến trang đăng nhập và hiển thị thông báo
            echo "success";
            exit();
        } else {
            // Người dùng đã tồn tại, chuyển hướng người dùng trở lại trang đăng ký và hiển thị thông báo lỗi
            echo "error";
            exit();
        }
    } else {
        // Dữ liệu không hợp lệ, chuyển hướng người dùng trở lại trang đăng ký và hiển thị thông báo lỗi
        $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin đăng ký.";
        header("Location: ../views/client/register.php");
        exit();
    }
}
