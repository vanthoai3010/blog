<?php
// Trong HomeController.php

class HomeController {
    public function index() {
        // Include file cấu hình cơ sở dữ liệu
        include 'config/database.php';

        // Truy vấn cơ sở dữ liệu để lấy danh sách danh mục
        $stmt = $db->query('SELECT * FROM categories');
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Load view home.php và truyền dữ liệu danh mục vào đó
        include 'views/client/home.php';
    }
}
