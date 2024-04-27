
// check validate
function dangkyValidate() {
    $('.err').remove();
    let username = $('#username').val();
    let phone = $('#phone').val();
    let diachi = $('#diachi').val();
    let email = $('#email').val();
    let password = $('#password').val();
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
        if (password === '') {
            let passwordErr = '<div class="err"><span style="color:red;">Vui lòng nhập vào mật khẩu!</span></div>';
            $('#password').after(passwordErr);
        }
        return false;
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
}// thông báo lỗi
function showSuccessErrMessage(message) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: message,
        showConfirmButton: false,
        timer: 3000 // Thời gian hiển thị thông báo (miligiây)
    })
}
// đăng ký tài khoản
document.getElementById("register").addEventListener('submit', function (event) {
    // event.prevenDefault ngăn chặn load lại trang
    event.preventDefault();
    // lấy dữ liệu từ form
    var formData = new FormData(this);
    // gửi yêu cầu từ ajax 
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/mvc/controllers/RegisterController.php', true);
    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            var response = xhr.responseText;
            if (response === "success") {
                showSuccessUpMessage("Đăng ký thành công! Bạn có thể đăng nhập")
            } if (response === "error") {
                showSuccessErrMessage("Trùng tài khoản hoặc có lỗi xảy ra!")
            }
        }
    }
    xhr.send(formData);
});


