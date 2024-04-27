<?php
session_start();
include '../config/database.php';

if (isset($_GET['search'])) {
    $search = $_GET['search'];

    try {
        // Query to search in title or category column
        $query = "SELECT * FROM posts WHERE title LIKE :search OR categories LIKE :search";
        
        // Prepare the statement
        $statement = $db->prepare($query);
        
        // Bind the search parameter
        $statement->bindValue(':search', "%$search%", PDO::PARAM_STR);
        
        // Execute the query
        $statement->execute();
        
        // Fetch all results
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        if($results) {
            $_SESSION['search_results'] = $results;
        }

        header('Location: /mvc/views/client/search.php');
        exit();
    } catch(PDOException $e) {
        // Handle errors
        echo "Lỗi truy vấn: " . $e->getMessage();
    }
}
?>
