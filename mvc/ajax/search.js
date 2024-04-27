$(document).ready(function() {
    $('.search-category').click(function(e) {
        e.preventDefault(); // Ngăn chặn hành động mặc định của phần tử <a>

        var categoryName = $(this).data('category'); // Lấy tên danh mục từ data-category

        // Chuyển hướng đến trang SearchPostController.php với tham số search là tên danh mục
        window.location.href = '/mvc/controllers/CategoriesPostController.php?search=' + encodeURIComponent(categoryName);
    });
});