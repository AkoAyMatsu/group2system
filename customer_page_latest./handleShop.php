<?php
$host = "localhost";
$user_db = "root";
$pass_db = "";
$name_db = "bwrs";

$conn = mysqli_connect($host, $user_db, $pass_db, $name_db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$products = []; // Initialize an array to store products

try {
    if (isset($_SESSION['user_id'])) {

        
        $userid = $_SESSION['user_id'];
        $product_table = "products";
        $product_query = "SELECT product_id, product_img, product_buy_price, product_refill_price, product_quantity, product_borrow_price, product_type FROM $product_table";
        $result = $conn->query($product_query);

        if ($result) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $products[] = $row; // Store each product in the $products array
                }
            } else {
                echo "No products found.";
            }
        } else {
            throw new Exception("Error in executing the query: " . $conn->error);
        }
    }
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

$conn->close();
?>