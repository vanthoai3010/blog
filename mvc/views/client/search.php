<?php
session_start();
?>

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

    <!-- Title -->
    <title>Blog</title>

    <!-- Favicon -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Core Stylesheet -->
    <link href="/mvc/Public/client/css/style.css" rel="stylesheet">
    <link href="/mvc/Public/client/css/home.css" rel="stylesheet">

    <!-- Responsive CSS -->
    <link href="/mvc/Public/client/css/responsive/responsive.css" rel="stylesheet">
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
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="yummyDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Danh mục blog</a>
                                    <div class="dropdown-menu" aria-labelledby="yummyDropdown">
                                        <a class="dropdown-item" href="/mvc">Bóng đá</a>
                                        <a class="dropdown-item" href="/mvc/views/client/create_post.php">Đời sống</a>
                                        <a class="dropdown-item" href="/mvc/views/client/profile.php">Thời sự</a>
                                    </div>
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
        <div class="container">
            <h2>Kết quả tìm kiếm</h2>
            <div class="row">
                <div>
                    <?php
                    if (isset($_SESSION['search_results'])) {
                        $search_results = $_SESSION['search_results'];
                        foreach ($search_results as $row) {
                    ?>
                            <div style="margin-bottom: 25px;" class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <a href="/mvc/views/client/single_page.php?post_id=<?php echo $row['post_id'] ?>">
                                            <h5 class="card-title"><?php echo $row['title']; ?></h5>
                                        </a>
                                        <p class="card-text">Danh mục: <?php echo $row['categories']; ?></p>
                                        <a href="/mvc/views/client/single_page.php?post_id=<?php echo $row['post_id'] ?>">
                                            <img style="width: 550px;" src="/mvc/public/client/img/user/<?php echo $row['hinh_anh'] ?>" alt="" srcset="">
                                        </a> <br>
                                        <button type="submit" class="btn"><a style="color:brown" href="/mvc/views/client/single_page.php?post_id=<?php echo $row['post_id'] ?>">Đọc tiếp</a></button>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                        // Xóa kết quả tìm kiếm sau khi đã sử dụng
                        unset($_SESSION['search_results']);
                    } else {
                        echo '<div class="alert alert-warning" role="alert">Không có kết quả tìm kiếm.</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </header>
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