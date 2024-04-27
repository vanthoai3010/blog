function checkProfileValidate() {
    $('.err').remove();
    let username = $('#username').val();
    let phone = $('#phone').val();
    let diachi = $('#diachi').val();
    let email = $('#email').val();
    // Biểu thức chính quy kiểm tra số điện thoại bắt đầu bằng số 0 và theo sau là 9 chữ số
    let phoneRegex = /^0\d{9}$/;
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (username !== '' && phone !== '' && diachi !== '' && email !== '') {
        // Kiểm tra số điện thoại bằng biểu thức chính quy
        if (!phoneRegex.test(phone)) {
            let phoneErr = '<div class="err"><span style="color:red;">Số điện thoại phải bắt đầu bằng số 0 và có 10 chữ số!</span></div>';
            $('#phone').after(phoneErr);
            return false;
        }
        if (!emailRegex.test(email)) {
            let emailErr = '<div class="err"><span style="color:red;">Định dạng email phải là example@gmail.com!</span></div>';
            $('#email').after(emailErr);
            return false;
        }
        return true;

    } else {
        if (username === '') {
            let usernameErr = '<div class="err"><span style="color:red;">Vui lòng nhập tên người dùng!</span></div>';
            $('#username').after(usernameErr);
        }
        if (phone === '') {
            let phoneErr = '<div class="err"><span style="color:red;">Vui lòng nhập số điện thoại!</span></div>';
            $('#phone').after(phoneErr);
        }
        if (diachi === '') {
            let diachiErr = '<div class="err"><span style="color:red;">Vui lòng nhập vào địa chỉ!</span></div>';
            $('#diachi').after(diachiErr);
        }
        if (email === '') {
            let emailErr = '<div class="err"><span style="color:red;">Vui lòng nhập vào email!</span></div>';
            $('#email').after(emailErr);
        }
        return false;
    }
}
// show thông báo
function showSuccessUpMessage(message) {
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: message,
        showConfirmButton: false,
        timer: 3000 // Thời gian hiển thị thông báo (miligiây)
    })
}
// edit profile
document.getElementById("editProfile").addEventListener('submit', function (event) {
    // event.preventDefault ngăn chặn load lại trang
    event.preventDefault();

    // Kiểm tra điều kiện nhập liệu trước khi gửi yêu cầu AJAX
    if (checkProfileValidate()) {
        // lấy dữ liệu từ form
        var formData = new FormData(this);

        // gửi yêu cầu từ ajax 
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/mvc/controllers/EditProfileController.php', true);
        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                var response = xhr.responseText;
                if (response === "success") {
                    showSuccessUpMessage("Cập nhật thành công!");
                }
            } else {
                alert("Lỗi");
            }
        };
        xhr.send(formData);
    }
});
