<?php
session_start();
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
} else {
    header("Location: /mvc/views/client/login.php");
    exit();
}

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

        .post-item {
            display: flex;
            margin-bottom: 20px;
            /* justify-content: space-between; */
        }

        .post-title {
            margin: 0;
            text-align: left;
        }

        .post-time {
            margin-top: 5px;
            color: #888;
            font-size: 14px;
            text-align: left;
        }

        #btn_del {
            margin-left: 150px;
            width: 70px;
            height: 40px;
        }
    </style>
</head>

<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "blog";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }
    if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
        $post_id = $_GET['delete'];

        // Thực hiện truy vấn SQL để xóa sản phẩm có ID tương ứng
        $sql = "DELETE FROM saved_posts WHERE post_id=$post_id";
        if ($conn->query($sql) === TRUE) {
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo '<script>
            Swal.fire({
                title: "Good job!",
                text: "Xóa bài viết thành công!",
                icon: "success"
            }).then((result) => {
                // Sau khi người dùng đóng thông báo, chuyển hướng trang không có tham số
                if (result.isConfirmed) {
                    window.location.href = window.location.href.split("?")[0];
                }
            });
        </script>';
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
    }
    ?>


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
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <div class="container text-center">
        <div class="row">
            <div class="col-md-4">
                <h2>Tin đã lưu</h2>
            </div>
            <div class="col-md-8">
                <?php
                // Lấy ID người dùng từ session
                $user_id = $_SESSION['user']['user_id'];

                // Truy vấn để lấy thông tin các bài viết đã lưu của người dùng
                $sql_saved_posts = "SELECT p.title, p.content, p.hinh_anh, p.created_at, p.post_id 
                    FROM saved_posts sp
                    JOIN posts p ON sp.post_id = p.post_id
                    WHERE sp.user_id = ?";
                $stmt_saved_posts = $conn->prepare($sql_saved_posts);
                $stmt_saved_posts->bind_param("i", $user_id);
                $stmt_saved_posts->execute();
                $result_saved_posts = $stmt_saved_posts->get_result();

                // Hiển thị danh sách các bài viết đã lưu
                while ($row_saved_posts = $result_saved_posts->fetch_assoc()) {
                    echo '<table>';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th style="width: 20%;">ID: ' . $row_saved_posts['post_id'] . '</th>';
                    echo '<th style="width: 40%;"></th>';
                    echo '<th style="width: 20%;"></th>';
                    echo '<th style="width: 20%;"></th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    echo '<tr>';
                    echo '<td><a href="/mvc/vies/client/single_page.php?post_id=' . $row_saved_posts['post_id'] . '"><img style="width: 160px; height: auto; margin-right: 10px;" src="/mvc/public/client/img/user/' . $row_saved_posts["hinh_anh"] . '"></a></td>';
                    echo '<td><a href="/mvc/views/client/single_page.php?post_id=' . $row_saved_posts['post_id'] . '">' . $row_saved_posts["title"] . '</a></td>';
                    echo '<td>' . $row_saved_posts["created_at"] . '</td>';
                    echo '<td><button id="btn_del" type="button" class="btn btn-danger"><a style="color:white;" href="/mvc/views/client/save_post.php?delete=' . $row_saved_posts['post_id'] . '">Xóa</a></button></td>';
                    echo '</tr>';
                    echo '</tbody>';
                    echo '</table>';
                }

                // Đóng kết nối
                $stmt_saved_posts->close();
                $conn->close();
                ?>
            </div>
        </div>
    </div>
    <script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.all.min.js
"></script>
    <script src="/mvc/Public/client/js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="/mvc/Public/client/js/bootstrap/popper.min.js"></script>
    <!-- Bootstrap-4 js -->
    <script src="/mvc/Public/client/js/bootstrap/bootstrap.min.js"></script>
    <!-- All Plugins JS -->
    <script src="/mvc/Public/client/js/others/plugins.js"></script>
    <!-- Active JS -->
    <script src="/mvc/Public/client/js/active.js"></script>
</body>

</html>