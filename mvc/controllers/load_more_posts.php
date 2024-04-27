<?php
// Thông tin kết nối đến cơ sở dữ liệu
$host = 'localhost';
$dbname = 'blog';
$username = 'root';
$password = '';

try {
    // Lấy số lượng bài viết đã hiển thị từ request POST
    $start = $_POST['start'];
    $limit = $_POST['limit'];
    // $displayedPostIds = $_POST['displayedPostIds'];

    // Kết nối đến cơ sở dữ liệu MySQL
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Thiết lập chế độ lỗi để PDO ném ngoại lệ nếu có lỗi
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Chuẩn bị và thực thi truy vấn SQL để lấy thêm bài viết không trùng lặp post_id
    if (!empty($displayedPostIds)) {
        $placeholders = rtrim(str_repeat('?,', count($displayedPostIds)), ',');
        $sql = "SELECT * FROM posts WHERE post_id NOT IN ($placeholders) ORDER BY created_at DESC LIMIT $start, $limit";
        $stmt = $conn->prepare($sql);
        $stmt->execute($displayedPostIds);
    } else {
        $sql = "SELECT * FROM posts ORDER BY created_at DESC LIMIT $start, $limit";
        $stmt = $conn->query($sql);
    }

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
    // Xử lý ngoại lệ nếu có lỗi kết nối hoặc truy vấn
    echo "Lỗi: " . $e->getMessage();
}
?>