<?php
// product_search.php

// Include database connection or any necessary files
include('database_connection.php');

// Check if the query parameter is set and not empty
if (isset($_POST['query']) && !empty($_POST['query'])) {
    // Sanitize the search query to prevent SQL injection
    $search_query = '%' . $_POST['query'] . '%';

    // Prepare the SQL statement to search for products by name
    $sql = "SELECT * FROM product WHERE product_name LIKE :search_query";

    // Prepare and execute the SQL statement
    $stmt = $connect->prepare($sql);
    $stmt->bindParam(':search_query', $search_query, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch the search results as an associative array
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are any results
    if ($results) {
        // Output the search results as HTML
        foreach ($results as $result) {
            echo '<div class="product">' . $result['product_name'] . '</div>';
            // You can customize the output according to your needs
        }
    } else {
        // If no results are found, display a message
        echo '<div class="alert alert-info">No products found.</div>';
    }
} else {
    // If the query parameter is not set or empty, display a message
    echo '<div class="alert alert-warning">Please enter a search query.</div>';
}
?>
