<?php
session_start();
if (isset($_SESSION['success_message'])) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>";
    echo "document.addEventListener('DOMContentLoaded', function () {";
    echo "const Toast = Swal.mixin({";
    echo "  toast: true,";
    echo "  position: 'top-end',";
    echo "  showConfirmButton: false,";
    echo "  timer: 3000,";
    echo "  timerProgressBar: true,";
    echo "  didOpen: (toast) => {";
    echo "    toast.onmouseenter = Swal.stopTimer;";
    echo "    toast.onmouseleave = Swal.resumeTimer;";
    echo "  }";
    echo "});";
    echo "Toast.fire({";
    echo "  icon: 'success',";
    echo "  title: 'Đăng nhập thành công!'";
    echo "  })";
    echo "});";
    echo "</script>";
    // Xóa thông báo thành công từ session sau khi đã hiển thị
    unset($_SESSION['success_message']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
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
    <style>
        .btn:focus {
            box-shadow: none;
        }
    </style>
</head>

<body>
    <?php
    // Thông tin kết nối đến cơ sở dữ liệu
    $host = 'localhost';
    $dbname = 'blog';
    $username = 'root';
    $password = '';
    // Kết nối đến cơ sở dữ liệu MySQL
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Thiết lập chế độ lỗi để PDO ném ngoại lệ nếu có lỗi
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Chuẩn bị và thực thi truy vấn SQL
    $stmt = $conn->prepare("SELECT * FROM categories");
    $stmt->execute();

    // Lấy kết quả trả về dưới dạng mảng kết hợp
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="yummyDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Danh mục blog</a>
                                    <div class="dropdown-menu" aria-labelledby="yummyDropdown">
                                        <?php
                                        try {
                                            foreach ($result as $row) {
                                        ?>
                                                <a id="dropdown-item" href="#" class="search-category" data-category="<?php echo $row['name']; ?>">
                                                    <?php echo $row['name']; ?>
                                                </a>
                                        <?php
                                            }
                                        } catch (PDOException $e) {
                                            echo "Lỗi: " . $e->getMessage();
                                        }
                                        ?>
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
    </header>
    <section class="welcome-post-sliders owl-carousel">

        <!-- Single Slide -->
        <div class="welcome-single-slide">
            <!-- Post Thumb -->
            <img src="/mvc/Public/client/img/bg-img/slide-1.jpg" alt="">
            <!-- Overlay Text -->
            <div class="project_title">
                <div class="post-date-commnents d-flex">
                    <a href="#">May 19, 2017</a>
                    <a href="#">5 Comment</a>
                </div>
                <a href="#">
                    <h5>“I’ve Come and I’m Gone”: A Tribute to Istanbul’s Street</h5>
                </a>
            </div>
        </div>

        <!-- Single Slide -->
        <div class="welcome-single-slide">
            <!-- Post Thumb -->
            <img src="/mvc/Public/client/img/bg-img/slide-2.jpg" alt="">
            <!-- Overlay Text -->
            <div class="project_title">
                <div class="post-date-commnents d-flex">
                    <a href="#">May 19, 2017</a>
                    <a href="#">5 Comment</a>
                </div>
                <a href="#">
                    <h5>“I’ve Come and I’m Gone”: A Tribute to Istanbul’s Street</h5>
                </a>
            </div>
        </div>

        <!-- Single Slide -->
        <div class="welcome-single-slide">
            <!-- Post Thumb -->
            <img src="/mvc/Public/client/img/bg-img/slide-3.jpg" alt="">
            <!-- Overlay Text -->
            <div class="project_title">
                <div class="post-date-commnents d-flex">
                    <a href="#">May 19, 2017</a>
                    <a href="#">5 Comment</a>
                </div>
                <a href="#">
                    <h5>“I’ve Come and I’m Gone”: A Tribute to Istanbul’s Street</h5>
                </a>
            </div>
        </div>

        <!-- Single Slide -->
        <div class="welcome-single-slide">
            <!-- Post Thumb -->
            <img src="/mvc/Public/client/img/bg-img/slide-4.jpg" alt="">
            <!-- Overlay Text -->
            <div class="project_title">
                <div class="post-date-commnents d-flex">
                    <a href="#">May 19, 2017</a>
                    <a href="#">5 Comment</a>
                </div>
                <a href="#">
                    <h5>“I’ve Come and I’m Gone”: A Tribute to Istanbul’s Street</h5>
                </a>
            </div>
        </div>

        <!-- Single Slide -->
        <div class="welcome-single-slide">
            <!-- Post Thumb -->
            <img src="/mvc/Public/client/img/bg-img/slide-4.jpg" alt="">
            <!-- Overlay Text -->
            <div class="project_title">
                <div class="post-date-commnents d-flex">
                    <a href="#">May 19, 2017</a>
                    <a href="#">5 Comment</a>
                </div>
                <a href="#">
                    <h5>“I’ve Come and I’m Gone”: A Tribute to Istanbul’s Street</h5>
                </a>
            </div>
        </div>
    </section>
    <!-- ****** danh mục blog ****** -->


    <!-- ****** danh mục blog ****** -->
    <section class="categories_area clearfix" id="about">
        <div class="container">
            <div class="row">
                <?php
                try {
                    foreach ($result as $row) {
                ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div style="margin-bottom: 60px;" class="single_catagory wow fadeInUp" data-wow-delay=".3s">
                                <div class="catagory-title">
                                    <a href="#" class="search-category" data-category="<?php echo $row['name']; ?>">
                                        <h5><?php echo $row['name']; ?></h5>
                                    </a>
                                </div>
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
    </section>

    <!-- ****** Blog Area Start ****** -->
    <section class="blog_area section_padding_0_80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="row">
                        <h4>Bài viết mới nhất</h4>
                        <!-- Single Post -->
                        <?php
                        try {
                            // Kết nối đến cơ sở dữ liệu MySQL
                            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                            // Thiết lập chế độ lỗi để PDO ném ngoại lệ nếu có lỗi
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            // Chuẩn bị và thực thi truy vấn SQL
                            $stmt = $conn->prepare("SELECT * FROM posts ORDER BY created_at DESC LIMIT 5");
                            $stmt->execute();

                            // Lấy kết quả trả về dưới dạng mảng kết hợp
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // Hiển thị thông tin từ mỗi hàng dữ liệu
                            foreach ($result as $row) {

                        ?>
                                <div class="col-12 col-md-12">
                                    <div class="single-post wow fadeInUp" data-wow-delay=".4s">
                                        <!-- Post Thumb -->
                                        <div class="post-thumb">
                                            <a href="/mvc/views/client/single_page.php?post_id=<?php echo $row['post_id'] ?>">
                                                <img style="width: 100%;" src="/mvc/public/client/img/user/<?php echo $row['hinh_anh'] ?>" alt="">
                                            </a>
                                        </div>
                                        <!-- Post Content -->
                                        <div class="post-content">
                                            <div class="post-meta d-flex">
                                                <div class="post-author-date-area ">
                                                    <!-- Post Author -->
                                                    <div class="post-author">
                                                        <a href="#">By <?php echo $row['create_by'] ?></a>
                                                    </div>
                                                    <!-- Post Date -->
                                                    <div class="post-date">
                                                        <a href="#">Đăng vào: <?php echo $row['created_at'] ?></a>
                                                    </div>
                                                </div>
                                                <!-- Post Comment & Share Area -->
                                                <div class="post-comment-share-area d-flex">
                                                    <!-- Post Favourite -->
                                                    <div class="post-favourite">
                                                        <a href="#"><i class="bi bi-bookmark-heart" aria-hidden="true"></i></a>
                                                    </div>
                                                    <!-- Post Comments -->
                                                    <div class="post-comments">
                                                        <a href="#"><i class="bi bi-chat-dots-fill" aria-hidden="true"></i></a>
                                                    </div>
                                                    <!-- Post Share -->
                                                    <div class="post-share">
                                                        <a href="#"><i class="bi bi-share-fill" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="/mvc/views/client/single_page.php?post_id=<?php echo $row['post_id'] ?>">
                                                <h4><?php echo $row['title'] ?></h4>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        } catch (PDOException $e) {
                            echo "Lỗi: " . $e->getMessage();
                        }
                        ?>
                        <div>
                            <button style="background-color:#4D2A62; color:white;" class="btn" id="loadMorePost" type="submit">Đọc thêm</button>
                        </div>
                    </div>
                </div>

                <!-- ****** Blog Sidebar ****** -->
                <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                    <div class="blog-sidebar mt-5 mt-lg-0">
                        <!-- Single Widget Area -->
                        <div class="user">
                            <div class="about_me">
                                <?php
                                if (isset($_SESSION['user'])) {
                                    $user = $_SESSION['user'];
                                    // Hiển thị thông tin người dùng
                                    echo '<div class="about-me">';
                                    echo '<div class="single-widget-area about-me-widget text-center">';
                                    echo '<div class="widget-title">';
                                    echo '<h6>About Me</h6>';
                                    echo '</div>';
                                    echo '<h4 class="font-shadow-into-light">Xin chào: ' . $user['username'] . '</h4>';
                                    echo '<p>' . $user['email'] . '</p>';
                                    echo "<button style='background-color:#083344; margin-bottom:30px; color:white;' type='button' class='btn'><a style='color:white;' href='/mvc/views/client/create_post.php'>Tạo bài đăng</a>
                                    </button>
                                    ";
                                    // echo "<a href='/mvc/controllers/Logincontroller.php?logout=1' style='color:red;'>Đăng xuất</a>";

                                    echo '</div>';
                                    // Đoạn mã HTML khác ở đây
                                    echo '</div>';
                                } else {
                                    // Nếu người dùng chưa đăng nhập, hiển thị nút đăng nhập
                                    echo '<div class="about-me">';
                                    echo "<button style='background-color:#FFAB00; margin-bottom:30px; color:white;' type='button' class='btn'><a style='color:white;' href='/mvc/views/client/login.php'>Tạo bài đăng của bạn ngay</a>
                                    </button>
                                    ";
                                    echo '</div>';
                                }
                                ?>
                            </div>
                            <!-- Single Widget Area -->
                            <div class="single-widget-area popular-post-widget">
                                <div class="widget-title text-center">
                                    <h6>Bài viết hay</h6>
                                </div>
                                <?php
                                try {
                                    // Kết nối đến cơ sở dữ liệu MySQL
                                    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                                    // Thiết lập chế độ lỗi để PDO ném ngoại lệ nếu có lỗi
                                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                    // Chuẩn bị và thực thi truy vấn SQL
                                    $stmt = $conn->prepare("SELECT * FROM popular_post");
                                    $stmt->execute();

                                    // Lấy kết quả trả về dưới dạng mảng kết hợp
                                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    // Hiển thị thông tin từ mỗi hàng dữ liệu
                                    foreach ($result as $row) {
                                ?>
                                        <!-- single product -->
                                        <div class="single-populer-post d-flex">
                                            <a href="/mvc/views/client/sg_page.php?post_id=<?php echo $row['post_id'] ?>">
                                                <img style="width:150px;" src="<?php echo $row['image_url'] ?>" alt="">
                                            </a>
                                            <div class="post-content">
                                                <a href="/mvc/views/client/sg_page.php?post_id=<?php echo $row['post_id'] ?>">
                                                    <h6><?php echo $row['title'] ?></h6>
                                                </a>
                                                <p>Đăng vào: <?php echo $row['posted_at'] ?> By Admin</p>
                                            </div>
                                        </div>
                                        <!-- single product -->
                                <?php
                                    }
                                } catch (PDOException $e) {
                                    // Xử lý ngoại lệ nếu có lỗi kết nối hoặc truy vấn
                                    echo "Lỗi: " . $e->getMessage();
                                }
                                ?>

                            </div>


                            <!-- Single Widget Area -->
                            <div class="single-widget-area newsletter-widget">
                                <div class="widget-title text-center">
                                    <h6>Newsletter</h6>
                                </div>
                                <p>Subscribe our newsletter gor get notification about new updates, information discount, etc.</p>
                                <div class="newsletter-form">
                                    <form action="#" method="post">
                                        <input type="email" name="newsletter-email" id="email" placeholder="Your email">
                                        <button type="submit"><i class="bi bi-send" aria-hidden="true"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <!-- ****** Footer Social Icon Area End ****** -->

    <!-- ****** Footer Menu Area Start ****** -->
    <footer class="footer-20192">
        <div class="site-section">
            <div class="container">

                <div class="cta d-block d-md-flex align-items-center px-5">
                    <div>
                        <h2 class="mb-0">Sẵn sàng tạo bài đăng cho riêng bạn?</h2>
                        <h3 class="text-dark">Let's get started!</h3>
                    </div>
                    <div class="ml-auto">
                        <a href="/mvc/views/client/create_post.php" class="btn btn-dark rounded-0 py-3 px-5">Tạo ngay</a>
                    </div>
                </div>
                <div class="row">

                    <div class="col-sm">
                        <a href="#" class="footer-logo">Colorlib</a>
                        <p class="copyright">
                            <small>&copy; 2019</small>
                        </p>
                    </div>
                    <div class="col-sm">
                        <h3 style="color:white;">Customers</h3>
                        <ul class="list-unstyled links">
                            <li><a href="#">Buyer</a></li>
                            <li><a href="#">Supplier</a></li>
                        </ul>
                    </div>
                    <div class="col-sm">
                        <h3 style="color:white;">Company</h3>
                        <ul class="list-unstyled links">
                            <li><a href="#">About us</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Contact us</a></li>
                        </ul>
                    </div>
                    <div class="col-sm">
                        <h3 style="color:white;">Further Information</h3>
                        <ul class="list-unstyled links">
                            <li><a href="#">Terms &amp; Conditions</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h3 style="color:white;">Follow us</h3>
                        <ul class="list-unstyled social">
                            <li><a href="#"><span class="bi bi-facebook"></span></a></li>
                            <li><a href="#"><span class="bi bi-twitter-x"></span></a></li>
                            <li><a href="#"><span class="bi bi-linkedin"></span></a></li>
                            <li><a href="#"><span class="bi bi-medium"></span></a></li>
                            <li><a href="#"><span class="bi bi-send-fill"></span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container d-flex justify-content-end  ">
            <a href="/mvc/#"><i style="font-size: 2rem; color:#ef4444; background-color:white; border-radius: 10px;" class="bi bi-arrow-up-circle-fill"></i></a>
        </div>
    </footer>
    <script src="/mvc/Public/client/js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="/mvc/Public/client/js/bootstrap/popper.min.js"></script>
    <!-- Bootstrap-4 js -->
    <script src="/mvc/Public/client/js/bootstrap/bootstrap.min.js"></script>
    <!-- All Plugins JS -->
    <script src="/mvc/Public/client/js/others/plugins.js"></script>
    <!-- Active JS -->
    <script src="/mvc/Public/client/js/active.js"></script>
    <script src="/mvc/ajax/search.js"></script>
    <script>
        var displayedPostIds = []; // Mảng để lưu trữ post_id đã hiển thị

        $(document).ready(function() {
            var start = 5; // Bắt đầu từ vị trí thứ 6 (do đã hiển thị 5 bài viết ban đầu)
            var limit = 3; // Hiển thị 3 bài viết mỗi lần load thêm

            $('#loadMorePost').on('click', function() {
                $.ajax({
                    url: '/mvc/controllers/load_more_posts.php', // Đường dẫn tới tập tin xử lý yêu cầu
                    type: 'POST',
                    data: {
                        start: start,
                        limit: limit,
                        displayedPostIds: displayedPostIds
                    }, // Truyền danh sách post_id đã hiển thị
                    success: function(response) {
                        $('#loadMorePost').before(response); // Thêm dữ liệu trả về vào trước nút "Đọc thêm"
                        start += limit; // Cập nhật vị trí bắt đầu cho lần load tiếp theo
                    }
                });
            });
        });
    </script>
</body>

</html>