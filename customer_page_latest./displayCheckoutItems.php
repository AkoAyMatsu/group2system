<?php

//session_regenerate_id();
// Assuming you have a database connection
$servername = "localhost";
$username = "root";
$password = ""; // Assuming no password
$dbname = "bwrs";

$customerOrderTable = "customer_order";
$checkoutOrderTable = "checkout_order";
$checkoutTable = "checkout";

$customerTable = "customer";
$productTable = "products";

$conn = new mysqli($servername, $username, $password, $dbname);

$checkoutItemsArray = [];

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_SESSION['user_id']) && isset($_SESSION['selectedOrderIds'])){
    //session_write_close();
    $userId = $_SESSION['user_id'];
    // Query to select the updated or selected orders
    $selectedOrderIds = implode(',', $_SESSION['selectedOrderIds']);

    $overallItems = $_SESSION['itemsToCheckout'];
    $overallPrice = $_SESSION['priceToCheckout'];
    $checkoutDate = $_SESSION['dateOfCheckout'];

    // Fetch user data from the database using the retrieved userId from the session
    $sql_order = "SELECT co.order_type, co.user_id, co.order_date, co.total_price, co.order_quantity, co.order_status, co.order_id, p.product_id, p.product_quantity, p.product_img, p.product_type, p.product_buy_price, p.product_refill_price, p.product_borrow_price
    FROM $customerOrderTable co
    JOIN $productTable p ON co.product_id = p.product_id
    WHERE co.user_id = $userId AND co.order_id IN ($selectedOrderIds)";



    //select the checkout_date, the order_quantity, the overall_price, the overall_items, the overall_items, the product_img, the order_type, the product_buy_price, the product_refill_price, the product_borrow_price.

    /*$sql_order = "SELECT cco*, cc.*, co.*, p.*;
    FROM $checkoutOrderTable cco
    JOIN $checkoutTable cc ON cco.checkout_id = cc.checkout_id
    JOIN $customerOrderTable co ON cco.order_id = co.order_id
    JOIN $productTable p ON cco.product_id = p.product_id
    WHERE cco.user_id = $userId AND cco.order_id IN (" . implode(',', $_SESSION['selectedOrderIds']) . ")";*/

    //$sql = "SELECT * FROM $tableName WHERE order_id IN (" . implode(',', $_SESSION['selectedOrderIds']) . ")";
    $result = $conn->query($sql_order);

    // Check if there are results
    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            $checkoutItemsArray[] = $row;
        }
    } else {
        echo "No results found";
    }
}


// Close the database connection
$conn->close();
?>
