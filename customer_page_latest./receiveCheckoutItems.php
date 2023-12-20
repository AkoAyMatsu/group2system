<?php
// Assuming you have a database connection
$servername = "localhost";
$username = "root";
$password = ""; // Assuming no password
$dbname = "bwrs"; // Replace with your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Replace 'your_checkout_table' with your actual checkout table name
// Replace 'your_checkout_order_table' with your actual checkout_order table name
define("TABLE_CHECKOUT", "checkout");
define("TABLE_CHECKOUT_ORDER", "checkout_order");
define("TABLE_CUSTOMER_ORDER", "customer_order");
define("TABLE_PRODUCT", "products");
define("TABLE_PAYMENT", "payment");

// Get all distinct checkout_ids with pending status orders
$getCheckoutIdsQuery = "SELECT DISTINCT co.checkout_id
                       FROM " . TABLE_CHECKOUT_ORDER . " co
                       JOIN " . TABLE_CUSTOMER_ORDER . " coo ON co.order_id = coo.order_id
                       WHERE coo.order_status = 'Pending'";

$result = $conn->query($getCheckoutIdsQuery);

if ($result->num_rows > 0) {
    $checkoutIds = [];

    while ($row = $result->fetch_assoc()) {
        $checkoutIds[] = $row['checkout_id'];
    }

    // Select orders related to the checkout_ids with pending status, ordered by checkout date
    $getOrdersQuery = "SELECT co.*, p.*, coo.*, pm.*, ch.* FROM " . TABLE_CHECKOUT_ORDER . " co
                       JOIN " . TABLE_PRODUCT . " p ON co.product_id = p.product_id
                       JOIN " . TABLE_PAYMENT . " pm ON co.payment_id = pm.payment_id
                       JOIN " . TABLE_CUSTOMER_ORDER . " coo ON co.order_id = coo.order_id
                       JOIN " . TABLE_CHECKOUT . " ch ON co.checkout_id = ch.checkout_id
                       WHERE co.checkout_id IN (" . implode(",", $checkoutIds) . ")
                       ORDER BY coo.order_date ASC";

    $ordersResult = $conn->query($getOrdersQuery);

    if ($ordersResult->num_rows > 0) {
        $orders = [];

        while ($orderRow = $ordersResult->fetch_assoc()) {
            $orders[] = $orderRow;
        }

        // Return the orders as JSON
        header('Content-Type: application/json');

        echo json_encode(['success' => true, 'message' => 'Orders successfully retrieved!', 'checkout_ids' => $checkoutIds, 'orders' => $orders]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No orders found for the checkout_ids with pending status']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No checkout_ids found with pending status orders']);
}

// Close the database connection
$conn->close();
?>
