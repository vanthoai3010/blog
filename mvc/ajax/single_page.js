// Bắt sự kiện khi người dùng nhấn nút gửi bình luận
document.getElementById("submitComment").addEventListener("click", function (event) {
    event.preventDefault(); // Ngăn chặn hành động mặc định của form

    var commentContent = document.getElementById("comment").value;
    if (commentContent.trim() === "") {
        alert("Vui lòng nhập bình luận!");
        return;
    }
    // Gửi yêu cầu AJAX để thêm bình luận
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/mvc/controllers/CommentController.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Phản hồi thành công
                if (xhr.responseText === "success") {
                    // Hiển thị thông báo thành công bằng SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Gửi bình luận thành công!',
                        text: "Đang chờ xét duyệt!",
                        showConfirmButton: false,
                        timer: 2000
                    }).then((result) => {
                        document.getElementById("comment").value = "";
                    });
                } else {
                    // Xử lý lỗi nếu cần
                }
            } else {
                // Xử lý lỗi nếu cần
            }
        }
    };
    xhr.send("comment=" + encodeURIComponent(commentContent));
});



// lưu bài viết
$(document).ready(function () {
    $('#save_success').click(function (event) {
        $.ajax({
            type: 'POST',
            url: '../../controllers/SavePostController.php',
            data: {
                save_success: true
            },
            success: function (response) {
                // Lưu session khi nhấn nút "Lưu"
                window.location.reload(); // Tải lại trang sau khi lưu
            }
        });
    });

    $('#save_cancel').click(function (event) {
        $.ajax({
            type: 'POST',
            url: '../../controllers/SavePostController.php',
            data: {
                save_cancel: true
            },
            success: function (response) {
                // Hủy session khi nhấn nút "Hủy lưu"
                window.location.reload(); // Tải lại trang sau khi hủy
            }
        });
    });
});
// đánh giá bài viết