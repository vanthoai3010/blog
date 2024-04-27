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
require __DIR__ . '/../../config/database.php';

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
                            <a href="#"><i class="bi bi-person-check" aria-hidden="true">Admin page</i></a>
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
    <div>
        <?php
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $post_id = $_GET['id'];

            // Truy vấn để lấy thông tin bài viết cần chỉnh sửa từ cơ sở dữ liệu
            function getPostData($db, $post_id)
            {
                $sql = "SELECT * FROM posts WHERE post_id = ?";
                $stmt = $db->prepare($sql);
                $stmt->execute([$post_id]);
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }

            // Lấy thông tin bài viết
            $post = getPostData($db, $post_id);
            if ($post) {

        ?>
                <form id="editPost" onsubmit="return validateCreatePost()">
                    <div class="container">
                        <div class="container ">
                            <div class="row d-flex ">
                                <div class="col-9">
                                    <input type="hidden" name="post_id" id="post_id" value=" <?php echo $post['post_id'] ?>">
                                    <label for="">Tiêu đề</label>
                                    <input type="text" name="title" id="title" value="<?php echo $post['title'] ?>" class="form-control">
                                    <label for="">Nội dung</label>
                                    <textarea style="margin-top: 10px;" name="content" id="content" cols="30" rows="10" class="form-control"><?php echo $post['content'] ?></textarea>
                                    <span style="margin-top: 10px;">Danh mục:</span>
                                    <select name="categories" id="categories" style="margin-top: 10px;" class="form-select" aria-label="Default select example">
                                        <option selected><?php echo $post['categories'] ?></option>
                                        <?php
                                        try {
                                            $query = "SELECT * FROM categories";
                                            $statement = $db->query($query);
                                            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                                                echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                                            }
                                        } catch (PDOException $e) {
                                            // Xử lý lỗi nếu truy vấn không thành công
                                            echo "Lỗi truy vấn: " . $e->getMessage();
                                        }
                                        ?>
                                    </select>
                                    <label for="file">Hình ảnh:</label> <br>
                                    <input type="file" id="file" name="file" accept="image/*" <?php echo $post['hinh_anh'] ?>>
                                </div>
                                <div class="col-md-3">
                                    <button style="margin: 50px;" id="btn-post" class="btn" type="submit">Cập nhật</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
        <?php
            } else {
                echo "Không tìm thấy bài viết.";
            }
        } else {
            echo "Thiếu thông tin ID bài viết.";
        }
        ?>
    </div>
    <div>
        <p><a href="/mvc/views/admin/admin.php">Quay lại</a></p>
    </div>
    <script>
        tinymce.init({
            selector: '#content'
        });
    </script>
    <script src="/mvc/ajax/create_post.js"></script>
    <script src="/mvc/ajax/admin.js"></script>
    <script src="/mvc/Public/client/js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="/mvc/Public/client/js/bootstrap/popper.min.js"></script>
    <!-- Bootstrap-4 js -->
    <script src="/mvc/Public/client/js/bootstrap/bootstrap.min.js"></script>
    <!-- All Plugins JS -->
    <script src="/mvc/Public/client/js/others/plugins.js"></script>
    <!-- Active JS -->
    <script src="/mvc/Public/client/js/active.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>