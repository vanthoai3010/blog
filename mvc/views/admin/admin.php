<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user'])) {
    // Nếu chưa đăng nhập, chuyển hướng người dùng về trang đăng nhập
    header("Location: /mvc/views/client/login.php");
    exit();
}

// Kiểm tra vai trò của người dùng
if ($_SESSION['user']['role'] != 1) {
    // Nếu vai trò không phải là admin, chuyển hướng người dùng về trang chính
    header("Location: /mvc/views/client/home.php");
    exit();
}
require __DIR__ . '/../../config/database.php';
function getPostsData($db)
{
    $sql = "SELECT * FROM posts";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// lấy dữ liệu bảng danh mục 
function getCategoriesData($db)
{
    $sql = "SELECT * FROM categories";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// lấy dữ liệu bảng comments
function getCommentsData($db)
{
    $sql = "SELECT * FROM comments";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// lây dữ liệu bảng users
function getUsersData($db)
{
    $sql = "SELECT * FROM users";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// lấy tổng số bài đăng trong ngày 
function getPostDateTotal($db)
{
    $sql = "SELECT DATE(created_at) AS post_day, COUNT(*) AS total_posts
        FROM posts
        GROUP BY DATE(created_at)
        ORDER BY DATE(created_at) DESC";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// lấy số bài đăng từ danh mục
function getCategoriesChart($db)
{
    // Chuẩn bị truy vấn SQL
    $sql = "SELECT categories, COUNT(*) AS total_posts
            FROM posts
            GROUP BY categories";

    // Chuẩn bị và thực thi câu truy vấn
    $stmt = $db->prepare($sql);
    $stmt->execute();

    // Lấy kết quả
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}



$PostDateTotal = getPostDateTotal($db);
$categoriesChart = getCategoriesChart($db);
$usersData = getUsersData($db);
$postsData = getPostsData($db);
$categoriesData = getCategoriesData($db);
$commentsData = getCommentsData($db);
// Lấy dữ liệu từ biến $PostDateTotal
$labels = array();
$data = array();

foreach ($PostDateTotal as $row) {
    // Thêm ngày vào mảng nhãn
    $labels[] = $row['post_day'];
    // Thêm tổng số bài đăng vào mảng dữ liệu
    $data[] = $row['total_posts'];
}
// Lấy dữ liệu từ biến $categoriesChart;
$labelCategories = array();
$dataCategories = array();

foreach ($categoriesChart as $row) {
    // Thêm tên danh mục vào mảng nhãn
    $labelCategories[] = $row['categories'];
    // Thêm tổng số bài đăng vào mảng dữ liệu
    $dataCategories[] = $row['total_posts'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- My CSS -->
    <link href="/mvc/Public/client/css/admin.css" rel="stylesheet">
    <link href="/mvc/Public/client/css/responsive/responsive.css" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/frs0az2aoqmf13eld33zdis6zjsydo6oxz1wt9rv3th71tlw/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>




    <title>AdminHub</title>
    <style>
        #content .content-section {
            display: none;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #BA68C8
        }

        .form-select:focus {
            box-shadow: none;
            border-color: red;
        }

        .badge {
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: initial;
            line-height: 1;
            padding: 0.5rem 0.7rem;
            font-weight: 500;
        }

        .checkPosts {
            position: absolute;
            top: 0;
            left: 0;
            margin-left: 0;
            margin-top: 0;
            z-index: 1;
            cursor: pointer;
            opacity: 0;
        }

        .dropdown {
            display: none;
        }

        .dropdown-menu {
            min-width: 520px;
            height: 50px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px 0;
            background-color: #F5F8FA;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            border-color: #083344;
        }

        .dropdown-item {
            padding: 10px 20px;
            font-size: 14px;
            color: #083344;
            text-decoration: none;
            display: block;
        }

        .dropdown-item:hover {
            background-color: #ecfdf5;
        }
    </style>
</head>

<body>


    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="#" class="brand">
            <i class="bi bi-person-circle"></i>
            <span class="text">Admin</span>
        </a>
        <ul class="side-menu top">
            <li class="active">
                <a href="#" data-content="posts">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Bài viết</span>
                </a>
            </li>
            <li>
                <a href="#" data-content="danh_muc">
                    <i class='bx bxs-shopping-bag-alt'></i>
                    <span class="text">Danh mục</span>
                </a>
            </li>
            <li>
                <a href="#" data-content="comments">
                    <i class='bx bxs-doughnut-chart'></i>
                    <span class="text">Bình luận</span>
                </a>
            </li>
            <li>
                <a href="#" data-content="users">
                    <i class='bx bxs-doughnut-chart'></i>
                    <span class="text">Users</span>
                </a>
            </li>
            <li>
                <a href="#" data-content="charts">
                    <i class='bx bxs-doughnut-chart'></i>
                    <span class="text">Thống kê</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="/mvc/controllers/Logincontroller.php?logout=1" class="logout">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- SIDEBAR -->



    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu'></i>
            <a href="#" class="nav-link"></a>
            <form>
                <div class="form-input">
                    <input type="search" name="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <a href="#" class="notification">
                <i class='bx bxs-bell'></i>
                <span class="num">8</span>
            </a>
        </nav>
        <!-- NAVBAR -->

        <!-- quản lý bài viết -->
        <main id="posts" class="content-section">
            <div class="container">
                <div style="padding-bottom: 50px;" class="d-flex justify-content-between ">
                    <h3>Phần quản lý bài viết</h3>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Thêm bài viết mới
                    </button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div style="width: 800px;" class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Tạo bài viết mới</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="container">
                                    <input type="text" name="title" id="title" placeholder="Tiêu đề" class="form-control" required>
                                    <textarea style="margin-top: 10px;" name="noidung" id="noidung" cols="30" rows="10" placeholder="Nội dung" class="form-control" required></textarea>
                                    <span style="margin-top: 10px;">Danh mục:</span>
                                    <select name="categories" id="categories" style="margin-top: 10px;" class="form-select" aria-label="Default select example">
                                        <option selected></option>
                                        <?php foreach ($categoriesData as $categories) : ?>
                                            <?php echo "<option value='" . $categories['name'] . "'>" . $categories['name'] . "</option>"; ?>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="file">Chọn hình ảnh:</label>
                                    <input type="file" id="file" name="file" accept="image/*">
                                    <input type="hidden" name="username" value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>">
                                    <input type="hidden" name="author_id" id="author_id" value="<?php echo $user['user_id'] ?>">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" onclick="create_post(event)">Tạo</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- xóa nhiều bài -->
                <div style="margin-bottom: 20px;" class="dropdown">
                    <select class="form-select" aria-label="Default select example" id="actionSelect" style="background-color: #F5F8FA; color:#083344; width:520px;">
                        <option selected disabled>Chọn hành động</option>
                        <option value="delete">Xóa nhiều bài</option>
                    </select>
                    <button style="margin-top: 25px;" type="button" class="btn btn-outline-primary btn-icon-text" onclick="deleteSelected(event)">
                        <i class="mdi mdi-file-check btn-icon-prepend"></i> Submit
                    </button>
                </div>

                <!-- xóa nhiều bài -->
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID bài biết</th>
                            <th scope="col"><input type="checkbox" name="checkall" id="checkall" onclick="checkAll()"></th>
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Tiêu đề</th>
                            <th scope="col">Đăng bởi</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col">Thời gian tạo</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($postsData as $post) : ?>
                            <tr id="row_<?php echo $post['post_id'] ?>">
                                <td><?php echo $post['post_id'] ?></td>
                                <td><input id="checkPost_<?php echo $post['post_id'] ?>" type="checkbox" name="checkPosts" id="checkPosts"></td>
                                <td><img style="width: 100px; border : radius 50%;" src="/mvc/public/client/img/user/<?php echo $post['hinh_anh'] ?>"></td>
                                <td><?php echo $post['title'] ?></td>
                                <td><?php echo $post['create_by'] ?></td>
                                <td><?php echo $post['categories'] ?></td>
                                <td><?php echo $post['created_at'] ?></td>
                                <td><button style="color:white;" class="btn btn-info " type="submit"><a style="color:white;" href="/mvc/views/admin/edit_post.php?id=<?php echo $post['post_id'] ?>">Sửa</a></button></td>
                                <td>
                                    <button style="color:white;" class="btn btn-danger" type="submit" onclick="deletePost(event, <?php echo $post['post_id']; ?>)">Xóa</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
        <!-- Quản lý danh mục bài viết -->
        <div id="danh_muc" class="content-section">
            <div class="container">
                <h3>Quản lý danh mục bài viết</h3>
                <!-- Button trigger modal -->
                <button style="margin: 30px;" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Thêm danh mục bài viết
                </button>

                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Thêm danh mục mới</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" class="form-control" name="add_dm" id="add_dm" placeholder="Tên danh mục bài viết" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onsubmit="return check_val()" onclick="add_dm(event)">Thêm</button>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID danh mục</th>
                            <th scope="col">Tên danh mục</th>
                            <th scope="col">Thời gian tạo</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categoriesData as $categories) : ?>
                            <tr id="row_<?php echo $categories['category_id'] ?>">
                                <td><?php echo $categories['category_id'] ?></td>
                                <td><?php echo $categories['name'] ?>
                                </td>
                                <td><?php echo $categories['created_at'] ?></td>
                                <td>
                                    <button style="color:white;" class="btn btn-danger" onclick="delete_danhmuc(event, <?php echo $categories['category_id'] ?>)" type="button">Xóa</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- quản lý bình luận -->
        <div id="comments" class="content-section">
            <div class="container">
                <h3>Quản lý bình luận</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nội dung bình luận</th>
                            <th scope="col">ID bài viết</th>
                            <th scope="col">Người đăng</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($commentsData as $comments) : ?>
                            <tr id="row_<?php echo $comments['id'] ?>">
                                <td><?php echo $comments['id'] ?></td>
                                <td><?php echo $comments['content'] ?></td>
                                <td><?php echo $comments['post_id'] ?></td>
                                <td><?php echo $comments['username'] ?></td>
                                <td><?php if ($comments['approved'] === 1) {
                                        echo "<label class='badge' style='background-color:#00d25b; color: #ffffff;'>Completed</label>";
                                    } else {
                                        echo "<label class='badge badge-danger'  style='background-color:red; color: #ffffff;'>Pending</label>";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if ($comments['approved'] === 1) {
                                        echo '<button id="duyet_btn_' . $comments['id'] . '" style="color:white; background-color:#f59e0b;" class="btn" type="button" onclick="an_cmt(event, ' . $comments['id'] . ')">Ẩn</button>';
                                    } else {
                                        echo '<button id="duyet_btn_' . $comments['id'] . '" style="color:white;" class="btn btn-info" type="button" onclick="duyet_cmt(event, ' . $comments['id'] . ')">Duyệt</button>';
                                    } ?>
                                </td>
                                <td>
                                    <button style="color:white;" class="btn btn-danger" type="submit" onclick="delete_cmt(event , <?php echo $comments['id'] ?>)">Xóa</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- quản lý người dùng -->
        <div id="users" class="content-section">
            <div class="container">
                <h3>Quản lý users</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID User</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Quyền</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usersData as $user) : ?>
                            <tr id="row_<?php echo $user['user_id'] ?>">
                                <td><?php echo $user['user_id'] ?></td>
                                <td><?php echo $user['username'] ?></td>
                                <td>
                                    <input id="email_<?php echo $user['user_id'] ?>" class="form-control" type="text" value="<?php echo $user['email'] ?>" disabled>
                                </td>
                                <td>
                                    <select class="form-select user-role" aria-label="Default select example" name="role">
                                        <option value="1" <?php echo ($user['role'] === 1) ? 'selected' : ''; ?>>Admin</option>
                                        <option value="0" <?php echo ($user['role'] === 0) ? 'selected' : ''; ?>>User</option>
                                    </select>
                                </td>
                                <td>
                                    <button style="color:white;" class="btn btn-primary" type="submit" onclick="edit_users(event, <?php echo $user['user_id'] ?>)">Update</button>
                                </td>
                                <td>
                                    <button style="color:white;" class="btn btn-danger" type="submit" onclick="delete_users(event, <?php echo $user['user_id'] ?>)">Delete</button>
                                </td>
                                <td id="buttonCell_<?php echo $user['user_id'] ?>">
                                    <button style="color:white;" class="btn btn-info" type="button" onclick="toggleEditSave(<?php echo $user['user_id'] ?>)">Chỉnh sửa</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- thống kê dữ liệu -->
        <div id="charts" class="content-section">
            <div style="height: 650px;" class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="text-center">Thống kê bài đăng theo ngày</h4>
                                <canvas id="chartDate"></canvas>
                            </div>
                        </div>
                    </div>
                    <div style="height: 350px; width: 546px;" class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4>Thống kê bài đăng theo danh mục</h4>
                                <canvas width="682" height="370" id="chartCategories"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- CONTENT -->

    <script src="/mvc/Public/client/js/jquery/jquery-2.2.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Lấy dữ liệu từ PHP và cập nhật biểu đồ
        const labelsCategories = <?php echo json_encode($labelCategories); ?>;
        const dataCategories = {
            labels: labelsCategories,
            datasets: [{
                label: 'Thống kê bài đăng theo danh mục',
                data: <?php echo json_encode($dataCategories); ?>,
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                    'rgb(34, 197, 94)',
                    'rgb(34, 211, 238',
                    'rgb(147, 51, 234'

                ],
                hoverOffset: 4
            }]
        };

        const dataCategoriesConfig = {
            type: 'doughnut',
            data: dataCategories,
        };

        var chartCategories = new Chart(
            document.getElementById('chartCategories'),
            dataCategoriesConfig
        );

        // thống kê bài đăng theo ngày 
        const labels = <?php echo json_encode($labels); ?>;
        const dataDate = {
            labels: labels,
            datasets: [{
                label: 'Số bài đăng trong ngày',
                data: <?php echo json_encode($data); ?>,
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        };

        const chartDateData = {
            type: 'line',
            data: dataDate,
        };

        var chartDate = new Chart(
            document.getElementById('chartDate'),
            chartDateData
        );
    </script>
    <script>
        tinymce.init({
            selector: '#noidung'
        });
    </script>
    <script src="/mvc/ajax/admin.js"></script>
    <script src="/mvc/ajax/admin_validate.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Xử lý sự kiện nhấp vào mục menu để hiển thị nội dung tương ứng
            const sideMenuItems = document.querySelectorAll('#sidebar .side-menu.top li a');

            sideMenuItems.forEach(item => {
                item.addEventListener('click', function(event) {
                    event.preventDefault();
                    const contentId = this.getAttribute('data-content');
                    showContent(contentId);
                });
            });

            function showContent(contentId) {
                const allContentSections = document.querySelectorAll('#content .content-section');
                allContentSections.forEach(section => {
                    section.style.display = 'none';
                });
                const selectedContent = document.getElementById(contentId);
                selectedContent.style.display = 'block';
            }

            // Xử lý sự kiện nhấp vào mục menu để đánh dấu mục đã được chọn
            const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

            allSideMenu.forEach(item => {
                const li = item.parentElement;

                item.addEventListener('click', function() {
                    allSideMenu.forEach(i => {
                        i.parentElement.classList.remove('active');
                    })
                    li.classList.add('active');
                })
            });

            // Xử lý sự kiện nhấp vào biểu tượng menu để ẩn/hiện sidebar
            const menuBar = document.querySelector('#content nav .bx.bx-menu');
            const sidebar = document.getElementById('sidebar');

            menuBar.addEventListener('click', function() {
                sidebar.classList.toggle('hide');
            })

            // Xử lý sự kiện nhấp vào nút tìm kiếm để hiển thị/hide form tìm kiếm trên các thiết bị nhỏ
            const searchButton = document.querySelector('#content nav form .form-input button');
            const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
            const searchForm = document.querySelector('#content nav form');

            searchButton.addEventListener('click', function(e) {
                if (window.innerWidth < 576) {
                    e.preventDefault();
                    searchForm.classList.toggle('show');
                    if (searchForm.classList.contains('show')) {
                        searchButtonIcon.classList.replace('bx-search', 'bx-x');
                    } else {
                        searchButtonIcon.classList.replace('bx-x', 'bx-search');
                    }
                }
            })

            // Ẩn sidebar trên các thiết bị nhỏ khi load trang
            if (window.innerWidth < 768) {
                sidebar.classList.add('hide');
            } else if (window.innerWidth > 576) {
                searchButtonIcon.classList.replace('bx-x', 'bx-search');
                searchForm.classList.remove('show');
            }

            // Xử lý sự kiện resize trình duyệt để điều chỉnh hiển thị của form tìm kiếm trên các thiết bị nhỏ
            window.addEventListener('resize', function() {
                if (this.innerWidth > 576) {
                    searchButtonIcon.classList.replace('bx-x', 'bx-search');
                    searchForm.classList.remove('show');
                }
            })

            // Xử lý sự kiện chuyển đổi chế độ tối sáng/tối cho trang web
            const switchMode = document.getElementById('switch-mode');

            switchMode.addEventListener('change', function() {
                if (this.checked) {
                    document.body.classList.add('dark');
                } else {
                    document.body.classList.remove('dark');
                }
            })
        });
    </script>
</body>

</html>