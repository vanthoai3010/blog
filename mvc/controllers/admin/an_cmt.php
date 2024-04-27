<?php
session_start();
include __DIR__ . '/../../config/database.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    try {
        $query = "UPDATE comments SET approved = 0 WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->execute(array(':id' => $id));
        echo "success";
        exit();
    } catch (PDOException $e) {
        echo "lỗi khi duyệt";
    }
} else {
    echo "ko có dữ liệu để duyệt";
}
