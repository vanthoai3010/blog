<?php
session_start();

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
} else {
    header("Location: /mvc/views/client/login.php");
    exit();
}
if (isset($_SESSION['profile_post'])) {
    $posts = $_SESSION['profile_post'];
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
    <script src="https://cdn.tiny.cloud/1/frs0az2aoqmf13eld33zdis6zjsydo6oxz1wt9rv3th71tlw/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- Title -->
    <title>Blog</title>
    <link href="/mvc/Public/client/css/home.css" rel="stylesheet">
    <link href="/mvc/Public/client/css/style.css" rel="stylesheet">
    <link rel="icon" href="img/core-img/favicon.ico">
    <link href="/mvc/Public/client/css/responsive/responsive.css" rel="stylesheet">
    <style>
        body {
            height: 1000px;
        }

        #tieude {
            border-color: #F57C00;
        }

        #tieude:hover {
            border-color: #000;
        }

        #btn-post {
            background-color: #FC6C3F;
            color: white;
        }

        #btn-post:hover {
            background-color: #000;
            color: white;
            /* width: 50px; */
        }

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
    <div class="dropdown d-flex justify-content-end ">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Xin chào : <?php echo $user['username'] ?>
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/mvc">Home</a></li>
            <li> <a class="dropdown-item" href="/mvc/controllers/Logincontroller.php?logout=1" style="color: red;">Đăng xuất</a>
            </li>
            <li><a class="dropdown-item" href="#"></a></li>
        </ul>
    </div>
    <!-- ****** Header Area Start ****** -->
    <header class="header_area">
        <div class="container">
            <div class="row">
                <!-- Logo Area Start -->
                <div class="col-12">
                    <div class="logo_area text-center">
                        <a href="#" class="yummy-logo">Edit Blog</a>
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
                                <li class="nav-item">
                                    <a class="nav-link" href="/mvc/views/client/profile.php">Trang cá nhân<span class="sr-only">(current)</span></a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <div>
        <?php
        // Kiểm tra xem id có được truyền qua URL không
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Tìm bài viết có id tương ứng trong danh sách bài viết
            $postToEdit = null;
            foreach ($posts as $post) {
                if ($post['post_id'] == $id) {
                    $postToEdit = $post;
                    break;
                }
            }

            if ($postToEdit) {
                // Hiển thị form chỉnh sửa với thông tin của bài viết
        ?>
                <form action="/mvc/controllers/EditPostController.php" method="POST" enctype="multipart/form-data" onsubmit="return validateCreatePost()">
                    <div class="container">
                        <div class="container ">
                            <div class="row d-flex ">
                                <div class="col-9">
                                    <input type="hidden" name="post_id" id="post_id" value=" <?php echo $postToEdit['post_id'] ?>">
                                    <label for="">Tiêu đề</label>
                                    <input type="text" name="title" id="title" value="<?php echo $postToEdit['title'] ?>" class="form-control">
                                    <label for="">Nội dung</label>
                                    <textarea style="margin-top: 10px;" name="content" id="content" cols="30" rows="10" class="form-control"><?php echo $postToEdit['content'] ?></textarea>
                                    <span style="margin-top: 10px;">Danh mục:</span>
                                    <select name="categories" id="categories" style="margin-top: 10px;" class="form-select" aria-label="Default select example">
                                        <option selected><?php echo $postToEdit['categories'] ?></option>
                                        <option value="Đồ ăn">Đồ ăn</option>
                                        <option value="Bóng đá">Bóng đá</option>
                                        <option value="Đời sống">Đời sống</option>
                                        <option value="Pháp luật">Pháp luật</option>
                                        <option value="Giải trí">Giải trí</option>
                                        <option value="Thời sự">Thời sự</option>
                                        <option value="Giáo dục">Giáo dục</option>
                                    </select>
                                    <label for="file">Hình ảnh:</label> <br>
                                    <input type="file" id="file" name="file" accept="image/*">
                                </div>
                                <div class="col-3">
                                    <button id="btn-post" class="btn" type="submit">Cập nhật</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
        <?php
            } else {
                echo "Không tìm thấy bài viết có id $id.";
            }
        } else {
            echo "Không có id được truyền qua URL.";
        }
        ?>

    </div>
    <script>
        tinymce.init({
            selector: '#content'
        });
    </script>
    <script src="/mvc/ajax/create_post.js"></script>
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