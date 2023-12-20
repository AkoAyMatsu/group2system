<?php
    session_start();

    // Replace these with your actual database connection details
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "bwrs";

    $customer_order_table = "customer_order";
    $product_table = "products"; // Corrected table name

    // Create a database connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $order_status = "Cancelled";

    // Select all items with "Cancelled" status, including the latest cancelled items, with product data
    $sql = "SELECT customer_order.*, $product_table.* 
            FROM $customer_order_table 
            JOIN $product_table ON customer_order.product_id = $product_table.product_id
            WHERE customer_order.order_status = '$order_status' 
            ORDER BY customer_order.order_date DESC";

    $result = $conn->query($sql);

    // Initialize an array to store the results
    $cancelledItems = [];

    // Check if there are results
    if ($result->num_rows > 0) {
        // Fetch and store the cancelled items in the array
        while ($row = $result->fetch_assoc()) {
            // Add each row to the results array
            $cancelledItems[] = $row;
        }
    }

    // Close the database connection
    $conn->close();

    // Output the array as JSON (you can modify this part based on your needs)
    header('Content-Type: application/json');
    echo json_encode($cancelledItems, JSON_PRETTY_PRINT);
?>
