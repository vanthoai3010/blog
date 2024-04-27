function validateCreatePost1() {
    $('.err').remove();
    let title = $('#title').val();
    let noidung = tinymce.get('noidung').getContent(); // Correct way to get content from TinyMCE
    let categories = $('#categories').val();
    let file = $('#file').val();

    if (title !== '' && noidung.trim() !== '' && categories !== '' && file !== '') {
        return true;
    } else {
        if (title === '') {
            let titleError = '<div class="err"><span style="color:red;">Vui lòng nhập tiêu đề</span></div>';
            $('#title').after(titleError);
        }
        if (noidung.trim() === '') {
            let contentError = '<div class="err"><span style="color:red;">Vui lòng nhập nội dung</span></div>';
            $('#noidung').after(contentError); // Corrected to target the textarea
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
