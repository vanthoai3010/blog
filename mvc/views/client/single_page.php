<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Title -->
    <title>Blog</title>
    <link href="/mvc/Public/client/css/home.css" rel="stylesheet">
    <link href="/mvc/Public/client/css/style.css" rel="stylesheet">
    <link rel="icon" href="img/core-img/favicon.ico">
    <link href="/mvc/Public/client/css/responsive/responsive.css" rel="stylesheet">
    <style>
        .save_post {
            width: 80px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            display: inline-block;
            border: 1px solid #e5e5e5;
            border-radius: 3px;
            color: #4f4f4f;

        }

        .form-control:focus {
            box-shadow: none;
            border-color: #BA68C8
        }
    </style>
</head>

<body>
    <?php

    // Thông tin kết nối đến cơ sở dữ liệu
    $host = 'localhost';
    $dbname = 'blog';
    $user = 'root';
    $password = '';
    // Kết nối đến cơ sở dữ liệu MySQL
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    // Thiết lập chế độ lỗi để PDO ném ngoại lệ nếu có lỗi
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    ?>

    <!-- <div id="preloader">
        <div class="yummy-load"></div>
    </div> -->


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
                        <a href="/mvc" class="yummy-logo">Blog</a>
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
                                    <a class="nav-link" href="/mvc/views/client/save_post.php">Bài viết đã lưu</a>
                                </li>
                                <?php if (isset($_SESSION['user'])) : ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/mvc/controllers/Logincontroller.php?logout=1" style="color: red;">Đăng xuất</a>
                                    </li>
                                <?php else : ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/mvc/views/client/login.php">Đăng nhập</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/mvc/views/client/register.php">Đăng ký</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <?php
    // Kiểm tra xem có tham số id truyền vào không
    if (isset($_GET['post_id'])) {
        $post_id = $_GET['post_id'];
        // lưu post_id vào session 
        $_SESSION['post_id'] = $post_id;
        try {
            $stmt = $conn->prepare("SELECT * FROM posts WHERE post_id  = :post_id");
            $stmt->bindParam(':post_id', $post_id);
            $stmt->execute();

            // Lấy kết quả trả về
            $post = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Xử lý ngoại lệ nếu có lỗi kết nối hoặc truy vấn
            echo "Lỗi: " . $e->getMessage();
        }
    } else {
        echo "Tham số id không được cung cấp.";
    }
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <h1><?php echo $post['title'] ?></h1>
                <div class="d-flex justify-content-between ">
                    <p>Đăng bởi : <?php echo $post['create_by'] ?></p>
                    <p>Thời gian: <?php echo $post['created_at'] ?></p>
                </div>
                <!-- <img style="width: 500px;" src="/mvc/public/client/img/user/<?php echo $post['hinh_anh'] ?>" alt="" srcset=""> -->
                <p></p>
                <p><?php echo $post['content'] ?></p>
                <!-- lưu bài viết -->
                <form method="POST" enctype="multipart/form-data">
                    <?php if (isset($_SESSION['user'])) : $user = $_SESSION['user'] ?>
                        <button id="saveButton" class="btn" type="button" onclick="savePost(<?php echo $post_id; ?>)"><i class="bi bi-bookmark">Lưu</i></button>
                    <?php else : ?>
                        <p>Đăng nhập để lưu bài viết</p>
                    <?php endif; ?>
                </form>
                <!-- lưu bài viết -->
                <div class="card">
                    <div class="card-header">
                        <h4>Bình luận</h4>
                    </div>
                    <div class="card-body">
                        <form action="../../controllers/CommentController.php" method="POST" enctype="multipart/form-data">
                            <textarea placeholder="Nhập bình luận" class="form-control" name="comment" id="comment" cols="30" rows="10" required></textarea>
                            <input type="hidden" name="post_id" id="post_id" value="<?php echo $post['post_id'] ?>">
                            <?php if (isset($_SESSION['user'])) : $user = $_SESSION['user']; ?>
                                <div class=" d-flex justify-content-between ">
                                    <p><b style="color:red;">Người dùng: </b><?php echo $user['username'] ?></p>
                                    <button id="submitComment" style="margin-top: 20px;" type="submit" class="btn btn-primary">Gửi bình luận </button>
                                </div>
                            <?php else : ?>
                                <li class="nav-item">
                                    <a class="nav-link d-flex justify-content-end " href="/mvc/views/client/login.php">Đăng nhập để bình luận</a>
                                </li>
                            <?php endif; ?>
                        </form>
                        <div>
                            <p style="color:#B42652; font-weight: 700;">Bình luận mới nhất</p>
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT * FROM comments WHERE approved = 1 AND post_id = :post_id ORDER BY created_at DESC ");
                                $stmt->bindParam(':post_id', $post_id);
                                $stmt->execute();
                                $approved_comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                // Hiển thị các bình luận đã được duyệt
                                foreach ($approved_comments as $comment) {
                            ?>
                                    <div style="margin-bottom: 20px;" class="card">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <img style="width: 30px;height: 30px;border-radius: 100%;" src="https://themewagon.github.io/corona-free-dark-bootstrap-admin-template/assets/images/faces-clipart/pic-1.png" alt="image">
                                                <h5 style="margin-left: 5px;" class="card-title"><?php echo $comment['username'] ?></h5>
                                                <p style="margin-left: 20px;" class="card-text"><?php echo $comment['content'] ?></p>
                                            </div>
                                            <p style="text-align: end;"><?php echo $comment['created_at'] ?></p>
                                        </div>
                                    </div>
                            <?php
                                }
                            } catch (PDOException $e) {
                                echo "Lỗi: " . $e->getMessage();
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/mvc/ajax/save_post.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.all.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/mvc/Public/client/js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="/mvc/Public/client/js/bootstrap/popper.min.js"></script>
    <!-- Bootstrap-4 js -->
    <script src="/mvc/Public/client/js/bootstrap/bootstrap.min.js"></script>
    <!-- All Plugins JS -->
    <script src="/mvc/Public/client/js/others/plugins.js"></script>
    <!-- Active JS -->
    <script src="/mvc/Public/client/js/active.js"></script>
    <script src="/mvc/ajax/single_page.js"></script>
</body>

</html>