function validateCreatePost() {
    $('.err').remove();
    let title = $('#title').val();
    let content = tinymce.get('content').getContent(); // Lấy nội dung từ trình soạn thảo TinyMCE
    let categories = $('#categories').val();
    let file = $('#file').val();

    if (title !== '' && content.trim() !== '' && categories !== '' && file !== '') {
        return true;
    } else {
        if (title === '') {
            let titleError = '<div class="err"><span style="color:red;">Vui lòng nhập tiêu đề</span></div>';
            $('#title').after(titleError);
        }
        if (content.trim() === '') { // Sử dụng trim để loại bỏ các khoảng trắng không cần thiết
            let contentError = '<div class="err"><span style="color:red;">Vui lòng nhập nội dung</span></div>';
            $('#content').after(contentError);
        }
        if (categories === '') {
            let categoryError = '<div class="err"><span style="color:red;">Vui lòng chọn danh mục</span></div>';
            $('#categories').after(categoryError);
        }
        if (file === '') {
            let fileError = '<div class="err"><span style="color:red;">Vui lòng chọn hình ảnh</span></div>';
            $('#file').after(fileError);
        }
        return false;
    }
}

