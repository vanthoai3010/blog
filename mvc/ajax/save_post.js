var isPostSaved = false; // Biến cờ kiểm tra xem bài viết đã được lưu hay chưa

function savePost(postId) {
    if (isPostSaved) {
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/mvc/controllers/SavePostController.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            if (this.responseText === "success") {
                // Hiển thị thông báo SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Post saved successfully!'
                });
                // Thay đổi biểu tượng của nút
            } else {
                // Hiển thị thông báo lỗi nếu cần
                Swal.fire({
                    title: 'Success',
                    text: 'Lưu bài thành công!'
                });
                document.getElementById("saveButton").innerHTML = '<i class="bi bi-bookmark-fill">Lưu</i>';
                isPostSaved = true; // Đánh dấu rằng bài viết đã được lưu
            }
        }
    };
    xhr.send("post_id=" + postId);
}