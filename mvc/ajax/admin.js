// checkbox post 
const checkboxes = document.querySelectorAll('input[name="checkPosts"]');
checkboxes.forEach((checkbox) => {
    checkbox.addEventListener('click', function () {
        // Lấy số lượng checkbox đã chọn
        const checkedCount = document.querySelectorAll('input[name="checkPosts"]:checked').length;

        // Hiển thị hoặc ẩn phần "Chọn hành động" tùy thuộc vào số lượng checkbox đã chọn
        const actionDropdown = document.querySelector('.dropdown');
        if (checkedCount > 0) {
            actionDropdown.style.display = 'block';
        } else {
            actionDropdown.style.display = 'none';
        }
    });
});
// chọn hết bài viết 
function checkAll() {
    var checkallCheckbox = document.getElementById("checkall");
    var checkboxes = document.querySelectorAll('input[name="checkPosts"]');

    checkboxes.forEach(function (checkbox) {
        checkbox.checked = checkallCheckbox.checked;
    });

    // Lấy số lượng checkbox đã chọn
    const checkedCount = document.querySelectorAll('input[name="checkPosts"]:checked').length;

    // Hiển thị hoặc ẩn phần "Chọn hành động" tùy thuộc vào số lượng checkbox đã chọn
    const actionDropdown = document.querySelector('.dropdown');
    if (checkedCount > 0) {
        actionDropdown.style.display = 'block';
    } else {
        actionDropdown.style.display = 'none';
    }
}

// sho thông báo thành công
function showSuccessUpMessage(message) {
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: message,
        showConfirmButton: false,
        timer: 3000 // Thời gian hiển thị thông báo (miligiây)
    })
}
function showSuccessDelMessage(message) {
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: message,
        showConfirmButton: false,
        timer: 3000 // Thời gian hiển thị thông báo (miligiây)
    }).then(function () {
        // Load lại trang sau khi hiển thị thông báo thành công
        location.reload();
    });
}


// edit post 
document.getElementById("editPost").addEventListener('submit', function (event) {
    // event.prevenDefault ngăn chặn load lại trang
    event.preventDefault();
    // lấy dữ liệu từ form
    var formData = new FormData(this);
    // gửi yêu cầu từ ajax 
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/mvc/controllers/admin/editpost.php', true);
    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            var response = xhr.responseText;
            if (response === "success") {
                showSuccessUpMessage("Cập nhật thành công!")
            }
        }
    }
    xhr.send(formData);
});
// // xóa post
function deletePost(event, post_id) {
    event.preventDefault();

    // Hiển thị hộp thoại xác nhận của SweetAlert2
    Swal.fire({
        title: 'Bạn có chắc chắn muốn xóa bài viết này?',
        text: "Hành động này sẽ không thể hoàn tác!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Có, xóa bài viết!',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        // Nếu người dùng xác nhận xóa
        if (result.isConfirmed) {
            // Thực hiện yêu cầu POST để xóa bài viết
            $.post('/mvc/controllers/admin/deletepost.php', { post_id: post_id })
                .done(function () {
                    // Ẩn dòng bài viết đã được xóa
                    $('#row_' + post_id).hide();
                    // Hiển thị thông báo xóa thành công của SweetAlert2
                    Swal.fire(
                        'Đã xóa!',
                        'Bài viết đã được xóa thành công.',
                        'success'
                    );
                })
                .fail(function () {
                    console.log("Lỗi xảy ra khi xóa bài viết.");
                });
        }
    });
}


//xóa danh mục
function delete_danhmuc(event, category_id) {
    event.preventDefault();
    // Hiển thị hộp thoại xác nhận của SweetAlert2
    Swal.fire({
        title: 'Bạn có chắc chắn muốn xóa danh mục này?',
        text: "Hành động này sẽ không thể hoàn tác!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Có, xóa danh mục!',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        // Nếu người dùng xác nhận xóa
        if (result.isConfirmed) {
            $.post('/mvc/controllers/admin/delete_danhmuc.php', { category_id: category_id })
                .done(function () {
                    $('#row_' + category_id).hide();
                    // Hiển thị thông báo xóa thành công của SweetAlert2
                    Swal.fire(
                        'Đã xóa!',
                        'Danh mục đã được xóa thành công.',
                        'success'
                    );
                })
                .fail(function () {
                    console.log("Lỗi xảy ra khi xóa danh mục.");
                });
        }
    });
}
// xóa bình luận 
function delete_cmt(event, id) {
    event.preventDefault();
    // Hiển thị hộp thoại xác nhận của SweetAlert2
    Swal.fire({
        title: 'Bạn có chắc chắn muốn xóa bình luận này?',
        text: "Hành động này sẽ không thể hoàn tác!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Có, xóa bình luận!',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        // Nếu người dùng xác nhận xóa
        if (result.isConfirmed) {
            $.post('/mvc/controllers/admin/delete_cmt.php', { id: id })
                .done(function () {
                    $('#row_' + id).hide();
                    // Hiển thị thông báo xóa thành công của SweetAlert2
                    Swal.fire(
                        'Đã xóa!',
                        'Bình luận đã được xóa thành công.',
                        'success'
                    );
                })
                .fail(function () {
                    console.log("Lỗi xảy ra khi xóa bình luận.");
                });
        }
    });
}
//


// duyệt bình luận
function duyet_cmt(event, id) {
    event.preventDefault();
    $.post('/mvc/controllers/admin/duyet_cmt.php', { id: id })
        .done(function (response) {
            if (response === "success") {
                showSuccessDelMessage("Duyệt thành công!");
            }
        })
        .fail(function () {
            console.log("Lỗi");
        });
}
function an_cmt(event, id) {
    event.preventDefault();
    $.post('/mvc/controllers/admin/an_cmt.php', { id: id })
        .done(function (response) {
            if (response === "success") {
                showSuccessDelMessage("Ẩn thành công!");
            }
        })
        .fail(function () {
            console.log("Lỗi");
        });
}
// tạo post
function create_post(event) {
    event.preventDefault();

    // Lấy dữ liệu từ form
    var title = $("#title").val();
    let noidung = tinymce.get('noidung').getContent();
    var categories = $("#categories").val();
    var file = $("#file").prop('files')[0]; // Lấy tệp hình ảnh

    // Tạo FormData object để chứa dữ liệu form
    var formData = new FormData();
    formData.append('title', title);
    formData.append('noidung', noidung);
    formData.append('categories', categories);
    formData.append('file', file);


    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/mvc/controllers/admin/create_post.php', true);
    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            var response = xhr.responseText;
            if (response === "success") {
                showSuccessUpMessage("Đăng bài thành công!")
            }
            else {
                showSuccessDelMessage("Đăng bài thành công!")
                $('#exampleModal').modal('hide');
                history.pushState({}, '', '/mvc/views/admin/admin.php');
            }
        }
    }
    xhr.send(formData);
}
// thêm danh mục

function add_dm(event) {
    event.preventDefault();

    // Lấy dữ liệu từ form
    var add_dm = $("#add_dm").val();

    // Tạo FormData object để chứa dữ liệu form
    var formData = new FormData();
    formData.append('add_dm', add_dm);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/mvc/controllers/admin/them_dm.php', true);
    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            var response = xhr.responseText;
            if (response === "success") {
                showSuccessDelMessage("Thêm danh mục thành công!");
                history.pushState({}, '', '/mvc/views/admin/admin.php');

            }
            else {
                console.log("Lỗi")
            }
        }
    }
    xhr.send(formData);
}
// xóa users
function delete_users(event, user_id) {
    event.preventDefault();
    // Hiển thị hộp thoại xác nhận của SweetAlert2
    Swal.fire({
        title: 'Bạn có chắc chắn muốn xóa user này?',
        text: "Hành động này sẽ không thể hoàn tác!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Có, xóa user!',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        // Nếu người dùng xác nhận xóa
        if (result.isConfirmed) {
            $.post('/mvc/controllers/admin/delete_users.php', { user_id: user_id })
                .done(function () {
                    $('#row_' + user_id).hide();
                    // Hiển thị thông báo xóa thành công của SweetAlert2
                    Swal.fire(
                        'Đã xóa!',
                        'User đã được xóa thành công.',
                        'success'
                    );
                })
                .fail(function () {
                    console.log("Lỗi xảy ra khi xóa user");
                });
        }
    });
}
// edit quyền users
function edit_users(event, user_id) {
    event.preventDefault();
    var role = $(event.target).closest('tr').find('.user-role').val();

    $.post('/mvc/controllers/admin/edit_users.php', { user_id: user_id, role: role })
        .done(function (response) {
            if (response === "success") {
                showSuccessUpMessage("Cập nhật thành công!")
            } else {
                alert("Update failed!");
            }
        })
        .fail(function () {
            console.log("Error");
        });
}
// edit users 
function toggleEditSave(user_id) {
    var buttonCell = document.getElementById('buttonCell_' + user_id);
    var saveButton = document.createElement('button');
    saveButton.innerHTML = 'Lưu';
    saveButton.className = 'btn btn-success';
    saveButton.setAttribute('onclick', 'saveUser(' + user_id + ')'); // Gọi hàm saveUser() khi nhấn vào nút "Lưu"
    buttonCell.innerHTML = '';
    buttonCell.appendChild(saveButton);

    var inputElement = document.getElementById('email_' + user_id);
    inputElement.removeAttribute('disabled');
}

function saveUser(user_id) {
    var inputElement = document.getElementById('email_' + user_id);
    var newEmail = inputElement.value;

    // Gửi dữ liệu cần cập nhật lên server bằng AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/mvc/controllers/admin/update_user.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Xử lý phản hồi từ server (nếu cần)
            // Ví dụ: hiển thị thông báo thành công
            showSuccessUpMessage("Cập nhật thành công!");
            // Sau khi cập nhật thành công, thay đổi nút "Lưu" thành "Chỉnh sửa" và vô hiệu hóa input
            var buttonCell = document.getElementById('buttonCell_' + user_id);
            buttonCell.innerHTML = '<button style="color:white;" class="btn btn-info" type="button" onclick="toggleEditSave(' + user_id + ')">Chỉnh sửa</button>';
            inputElement.setAttribute('disabled', 'disabled');
        }
    };
    xhr.send('user_id=' + user_id + '&email=' + encodeURIComponent(newEmail));
}

// xóa nhiều bài 
function deleteSelected(event) {
    event.preventDefault();
    var selectedAction = document.getElementById("actionSelect").value;
    if (selectedAction === "delete") {
        var selectedPosts = []; // Mảng chứa ID của các bài viết được chọn
        var checkboxes = document.querySelectorAll('input[name="checkPosts"]:checked'); // Lấy tất cả các ô checkbox được chọn
        checkboxes.forEach(function (checkbox) {
            // Lấy ID của bài viết từ ID của ô checkbox và thêm vào mảng
            var postId = checkbox.id.split("_")[1]; // Lấy ID của bài viết từ ID của ô checkbox
            selectedPosts.push(postId);
        });

        // Lấy số bài viết đã chọn
        var soBaiVietChon = selectedPosts.length;

        if (soBaiVietChon > 0) {
            // Hiển thị SweetAlert2 để xác nhận xóa
            Swal.fire({
                text: "Bạn có chắc chắn muốn xóa " + soBaiVietChon + " bài viết được chọn không?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Xóa"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Gửi danh sách các ID bài viết được chọn đến tệp PHP để xóa
                    $.post('/mvc/controllers/admin/xoa_nhieu_bai.php', { selectedPosts: selectedPosts })
                        .done(function (response) {
                            if (response === "success") {
                                selectedPosts.forEach(function (post_id) {
                                    $('#row_' + post_id).hide();
                                });
                                showSuccessUpMessage("Xóa thành công!");
                            } else {
                                console.error("Lỗi từ máy chủ: ", response);
                                alert("Có lỗi khi xóa bài");
                            }
                        })
                        .fail(function (xhr, status, error) {
                            console.error("Lỗi kết nối: ", status, error);
                            alert("Có lỗi khi kết nối đến máy chủ");
                        });
                }
            });
        } else {
            alert("Vui lòng chọn ít nhất một bài viết để xóa.");
        }
    }
}





