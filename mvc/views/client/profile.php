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
        /* --------------------
:: 2.0 Top Header Area CSS
-------------------- */



        .form-control:focus {
            box-shadow: none;
            border-color: #BA68C8
        }

        .profile-button {
            background: rgb(99, 39, 120);
            box-shadow: none;
            border: none
        }

        .profile-button:hover {
            background: #682773
        }

        .profile-button:focus {
            background: #682773;
            box-shadow: none
        }

        .profile-button:active {
            background: #682773;
            box-shadow: none
        }

        .back:hover {
            color: #682773;
            cursor: pointer
        }

        .labels {
            font-size: 14px
        }

        .add-experience:hover {
            background: #BA68C8;
            color: #fff;
            cursor: pointer;
            border: solid 1px #BA68C8
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

        // Tắt kiểm tra ràng buộc khóa ngoại trước khi xóa
        mysqli_query($conn, 'SET FOREIGN_KEY_CHECKS = 0');

        // Thực hiện truy vấn SQL để xóa bài viết có ID tương ứng
        $sql = "DELETE FROM posts WHERE post_id=$post_id";
        if ($conn->query($sql) === TRUE) {
            // Bật lại kiểm tra ràng buộc khóa ngoại sau khi xóa
            mysqli_query($conn, 'SET FOREIGN_KEY_CHECKS = 1');

            // Hiển thị thông báo thành công bằng JavaScript
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
            // Bật lại kiểm tra ràng buộc khóa ngoại trong trường hợp xóa thất bại
            mysqli_query($conn, 'SET FOREIGN_KEY_CHECKS = 1');

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
    <!-- ****** Top Header Area End ****** -->

    <!-- ****** Header Area Start ****** -->
    <header class="header_area">
        <div class="container">
            <div class="row">
                <!-- Logo Area Start -->
                <div class="col-12">
                    <div class="logo_area text-center">
                        <a href="/mvc/views/client/profile.php/" class="yummy-logo">Trang cá nhân</a>
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
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- profile -->
    <section>
        <form id="editProfile" onsubmit="return checkProfileValidate()">
            <div class="container rounded bg-white mt-5 mb-5">
                <div class="row">
                    <div class="col-md-5 border-right">
                        <input type="hidden" name="user_id" id="user_id" value="<?php echo $user['user_id']; ?>">
                        <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="/mvc/public/client/img/login/avatar-trang-4.jpg"><span class="font-weight-bold"><?php echo $user['username'] ?></span><span class="text-black-50"><?php echo $user['email'] ?></span><span> </span></div>
                    </div>
                    <div class="col-md-7 border-right">
                        <div class="p-3 py-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="text-right">Thông tin người dùng</h4>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6"><label class="labels">UserName</label><input id="username" name="username" type="text" class="form-control" value="<?php echo $user['username'] ?>"></div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12"><label class="labels">Mobile Number</label><input id="phone" name="phone" type="number" class="form-control" value="<?php echo $user['phone'] ?>"></div>
                                <div class="col-md-12"><label class="labels">Địa chỉ</label><input id="diachi" name="diachi" type="text" class="form-control" value="<?php echo $user['diachi'] ?>"></div>
                                <div class="col-md-12"><label class="labels">Vai trò</label><input type="text" class="form-control" value="<?php if ($user['role'] === 0) {
                                                                                                                                                echo "Người dùng";
                                                                                                                                            } else echo "Quản trị viên" ?>" disabled></div>
                                <div class="col-md-12"><label class="labels">Tạo vào lúc</label><input type="text" class="form-control" value="<?php echo $user['created_at'] ?>" disabled></div>
                                <div class="col-md-12"><label class="labels">Email</label><input id="email" name="email" type="" class="form-control" value="<?php echo $user['email'] ?>"></div>
                            </div>
                            <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="submit">Cập nhật</button></div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
        </form>
        <!-- quản lý bài viết -->
        <div>
            <div class="col-md-12">
                <div class="p-3 py-5">
                    <h4 class="text-center">Quản lý bài viết</h4>
                    <div class="col-md-12 text-left"><label class="labels">Bài viết đã đăng</label></div> <br>
                    <table class="table">
                        <tbody>
                            <?php
                            // Lấy thông tin username từ URL hoặc bất kỳ nguồn nào khác
                            $user_id = $user['user_id'];

                            // Truy vấn để lấy thông tin bài viết của người dùng với username tương ứng
                            $sql = "SELECT posts.* FROM posts INNER JOIN users ON posts.author_id = users.user_id WHERE users.user_id = '$user_id'";
                            $result = $conn->query($sql);
                            $_SESSION['profile_post'] = array();

                            if ($result->num_rows > 0) {
                                // In dữ liệu ra HTML
                                echo '<table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tiêu đề</th>
                    <th scope="col">Hình ảnh</th>
                    <th scope="col">Đăng vào lúc</th>
                    <th scope="col">Danh mục</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>';
                                while ($row = $result->fetch_assoc()) {
                                    $_SESSION['profile_post'][] = $row;
                                    echo '<tr>
    <td>' . $row["post_id"] . '</td>
    <td>' . $row["title"] . '</td>
    <td><img style="width: 150px;" src="/mvc/public/client/img/user/' . $row["hinh_anh"] . '"></td>
    <td>' . $row["created_at"] . '</td>
    <td>' . $row["categories"] . '</td>
    <td><button type="button" class="btn btn-primary"><a style="color:white;" href="/mvc/views/client/edit_post.php?id=' . $row['post_id'] . '">Edit<a/></button>
    </td>
    <td><button type="button" class="btn btn-danger"><a style="color:white;" href="/mvc/views/client/profile.php?delete=' . $row['post_id'] . '">Xóa<a/></button>
    </td>
</tr>';
                                }
                                echo '</tbody></table>';
                            } else {
                                echo "Không có bài viết nào được tìm thấy";
                            }

                            $conn->close();
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <script src="/mvc/ajax/profile.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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