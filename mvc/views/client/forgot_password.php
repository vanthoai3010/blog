<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Bỏ comment dòng sau nếu bạn đã cài đặt PHPMailer bằng Composer và có tệp autoload.php
require __DIR__ . '/../../vendor/autoload.php';

session_start();

// Thông tin kết nối đến cơ sở dữ liệu
$host = 'localhost';
$dbname = 'blog';
$username = 'root';
$password = '';

try {
    // Tạo kết nối đến cơ sở dữ liệu
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Thiết lập chế độ báo lỗi để hiển thị các thông báo lỗi của MySQL
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Thiết lập bộ mã kết nối
    $pdo->exec("set names utf8");
} catch (PDOException $e) {
    // Xử lý lỗi nếu kết nối không thành công
    echo "Lỗi kết nối: " . $e->getMessage();
    die(); // Dừng script
}

// Kiểm tra nếu người dùng đã gửi email
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST["email"];

    // Kiểm tra xem email tồn tại trong cơ sở dữ liệu hay không
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Tạo và lưu token reset password vào cơ sở dữ liệu
        $token = bin2hex(random_bytes(32));
        $expire = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Debug: In ra thông tin của token và thời gian hết hạn trước khi thực hiện câu truy vấn SQL
        echo "Token: " . $token . "<br>";
        echo "Thời gian hết hạn: " . $expire . "<br>";

        $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_token_expire = ? WHERE email = ?");
        echo "Câu truy vấn SQL: " . $stmt->queryString . "<br>";
        $stmt->execute([$token, $expire, $email]);

        // Gửi email chứa liên kết reset password
        $reset_link = "http://localhost:70/mvc/views/client/reset_password.php?token=$token";

        // Sử dụng PHPMailer để gửi email
        $mail = new PHPMailer(true);
        try {
            // Cài đặt thông tin SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Thay thế bằng SMTP server của bạn
            $mail->SMTPAuth = true;
            $mail->Username = 'buivanthoai3010@gmail.com'; // Thay thế bằng username của bạn
            $mail->Password = 'pwsy yqxf bfxp ubfn'; // Thay thế bằng password của bạn
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Cài đặt thông tin email
            $mail->setFrom('your_email@example.com', 'Your Name');
            $mail->addAddress($email);

            // Cài đặt tiêu đề và nội dung email
            $mail->isHTML(true);
            $mail->Subject = 'Reset Your Password';
            $mail->Body = "Click the link below to reset your password:<br><a href='$reset_link'>$reset_link</a>";

            $mail->send();
            $_SESSION['status'] = "Liên kết đã được gửi về hòm thư của bạn. Vui lòng kiểm tra hòm thư để thay đổi mật khẩu.";
        } catch (Exception $e) {
            $_SESSION['status'] = "Không thể gửi email. Lỗi: {$mail->ErrorInfo}";
        }

        header("Location: forgot_password.php");
        exit;
    } else {
        $_SESSION['status'] = "Không tìm thấy email trong cơ sở dữ liệu. Vui lòng kiểm tra lại.";
        header("Location: forgot_password.php");
        exit;
    }
}
?>


<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">

    <!-- Title -->
    <title>Blog</title>
    <link href="/mvc/Public/client/css/home.css" rel="stylesheet">
    <link href="/mvc/Public/client/css/style.css" rel="stylesheet">
    <link rel="icon" href="img/core-img/favicon.ico">
    <link href="/mvc/Public/client/css/responsive/responsive.css" rel="stylesheet">
    <style>
        .form-control:focus {
            box-shadow: none;
            border-color: #BA68C8
        }
    </style>
</head>

<body>
    <div id="preloader">
        <div class="yummy-load"></div>
    </div>
    <!-- ****** Top Header Area Start ****** -->
    <section>
        <div class="top_header_area">
            <div class="container">
                <div class="row">
                    <div class="col-5 col-sm-6">
                        <!--  Top Social bar start -->
                        <div class="top_social_bar">
                            <a href="#"><i class="bi bi-facebook" aria-hidden="true"></i></a>
                            <a href="#"><i class="bi bi-twitter" aria-hidden="true"></i></a>
                            <a href="#"><i class="bi bi-linkedin" aria-hidden="true"></i></a>
                            <a href="#"><i class="bi bi-skype" aria-hidden="true"></i></a>
                            <a href="#"><i class="bi bi-dribbble" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <!--  Login Register Area -->
                    <div class="col-7 col-sm-6">
                        <div class="signup-search-area d-flex align-items-center justify-content-end">
                            <!-- Search Button Area -->
                            <div class="search_button">
                                <a class="searchBtn" href="#"><i class="bi bi-search" aria-hidden="true"></i></a>
                            </div>
                            <!-- Search Form -->
                            <div class="search-hidden-form">
                                <form action="/mvc/controllers/SearchPostController.php" method="GET">
                                    <input type="search" name="search" id="search-anything" placeholder="Tìm kiếm bài viết...">
                                    <input type="submit" value="" class="d-none">
                                    <span class="searchBtn"><i class="bi bi-times" aria-hidden="true"></i></span>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ****** Top Header Area End ****** -->

    <!-- ****** Header Area Start ****** -->
    <header class="header_area">
        <div class="container">
            <div class="row">
                <!-- Logo Area Start -->
                <div class="col-12">
                    <div class="logo_area text-center">
                        <a href="/mvc/views/client/login.php/" class="yummy-logo">Đăng nhập</a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <nav class="navbar navbar-expand-lg">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#yummyfood-nav" aria-controls="yummyfood-nav" aria-expanded="false" aria-label="Toggle navigation"><i class="bi bi-bars" aria-hidden="true"></i> Menu</button>
                        <!-- Menu Area Start -->
                        <div class="collapse navbar-collapse justify-content-center" id="yummyfood-nav">
                            <ul class="navbar-nav" id="yummy-nav">
                                <li class="nav-item active">
                                    <a class="nav-link" href="/mvc">Home <span class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="yummyDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pages</a>
                                    <div class="dropdown-menu" aria-labelledby="yummyDropdown">
                                        <a class="dropdown-item" href="/mvc">Home</a>
                                        <a class="dropdown-item" href="/mvc/views/client/create_post.php">Đăng bài viết</a>
                                        <a class="dropdown-item" href="/mvc/views/client/profile.php">Trang cá nhân</a>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Contact</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/mvc/views/client/login.php/">Đăng nhập</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/mvc/views/client/register.php/">Đăng ký</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <?php if (isset($_SESSION['status'])) : ?>
        <div class="alert alert-success">
            <h5><?= $_SESSION['status']; ?></h5>
        </div>
        <?php unset($_SESSION['status']); ?>
    <?php endif; ?>

    <div class="card container ">
        <div class="card-header">
            <h5>Thay đổi mật khẩu</h5>
        </div>
        <div class="card-body p-4">
            <form action="" method="POST">
                <div class="form-group mb-3">
                    <label>Nhập vào email của bạn </label>
                    <input type="email" name="email" class="form-control" placeholder="Enter Email Address">
                </div>
                <button type="submit" class="btn btn-primary">Gửi link thay đổi</button>
            </form>
        </div>
    </div>
</body>
<script src="/mvc/Public/client/js/jquery/jquery-2.2.4.min.js"></script>
<!-- Popper js -->
<script src="/mvc/Public/client/js/bootstrap/popper.min.js"></script>
<!-- Bootstrap-4 js -->
<script src="/mvc/Public/client/js/bootstrap/bootstrap.min.js"></script>
<!-- All Plugins JS -->
<script src="/mvc/Public/client/js/others/plugins.js"></script>
<!-- Active JS -->
<script src="/mvc/Public/client/js/active.js"></script>

</html>