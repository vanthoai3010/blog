<?php
session_start();
include '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $diachi = $_POST['diachi'];
    $email = $_POST['email'];
    $user_id = $_POST['user_id'];

    // Tiến hành cập nhật dữ liệu vào cơ sở dữ liệu
    $sql = "UPDATE users SET username=?, phone=?, diachi=?, email=? WHERE user_id=?";
    $stmt = $db->prepare($sql);
    if ($stmt) {
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $phone);
        $stmt->bindParam(3, $diachi);
        $stmt->bindParam(4, $email);
        $stmt->bindParam(5, $user_id);
        $stmt->execute();

        // Kiểm tra xem truy vấn đã thực hiện thành công hay không
        if ($stmt->rowCount() > 0) {
            // Cập nhật lại session với dữ liệu mới
            $sql = "SELECT * FROM users WHERE user_id=?";
            $stmt = $db->prepare($sql);
            if ($stmt) {
                $stmt->bindParam(1, $user_id);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['user'] = $user; // Cập nhật session với thông tin người dùng mới
            }
            // Chuyển hướng người dùng đến trang profile.php
            echo "success";
            exit;
        } else {
            // Nếu không thành công, chuyển hướng người dùng đến trang profile.php và hiển thị thông báo lỗi
            header("Location: /mvc/views/client/profile.php?error=update_failed");
            exit;
        }
        $stmt->closeCursor();
    } else {
        // Xử lý lỗi khi không thể chuẩn bị câu lệnh truy vấn
        echo "Lỗi: Không thể chuẩn bị câu lệnh truy vấn.";
    }
} else {
    // Xử lý lỗi khi không phải là phương thức POST
    echo "Lỗi: Yêu cầu không hợp lệ.";
}

?>
