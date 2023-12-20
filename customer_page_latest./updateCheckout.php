<?php

session_start();

$servername = "localhost";
$username = "root";
$password = ""; // Assuming no password
$dbname = "bwrs"; // Replace with your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming your checkout table is named "checkout"
define("TABLE_CHECKOUT", "checkout");
define("TABLE_CHECKOUT_ORDER", "checkout_order");
define("TABLE_CUSTOMER_ORDER", "customer_order");

// Get the JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);

if (isset($_SESSION['user_id'])) {
    $current_user_id = $_SESSION['user_id'];

    // Check if the data is valid
    if ($data && isset($data['payment_id'], $data['payment_type'], $data['payment_total'], $data['payment_date'], $data['checkout_id'], $data['order_ids'])) {
        $payment_id = $data['payment_id'];
        $payment_type = $data['payment_type'];
        $payment_total = $data['payment_total'];
        $payment_date = $data['payment_date'];
        $checkout_id = $data['checkout_id'];
        $order_ids = $data['order_ids'];

        $orderStatus = "Pending";

        // Format date if needed
        // $formatted_checkout_date = date("Y-m-d H:i:s", strtotime($checkout_date));

        // Update customer_order table with payment_id
        foreach ($order_ids as $orderId) {
            $updateCustomerOrderQuery = "UPDATE " . TABLE_CUSTOMER_ORDER . " SET payment_id = ?, order_status = ? WHERE order_id = ?";
            $stmt = $conn->prepare($updateCustomerOrderQuery);
            $stmt->bind_param("sss", $payment_id, $orderStatus, $orderId);
            $stmt->execute();
            $stmt->close();
        }

        // Update checkout table with payment_id
        $updateCheckoutQuery = "UPDATE " . TABLE_CHECKOUT . " SET payment_id = ? WHERE checkout_id = ?";
        $stmt = $conn->prepare($updateCheckoutQuery);
        $stmt->bind_param("ss", $payment_id, $checkout_id);
        $stmt->execute();
        $stmt->close();

        // Update checkout_order table with payment_id\
        $checkoutOrderIds = implode(",", $order_ids);
        $updateCheckoutOrderQuery = "UPDATE " . TABLE_CHECKOUT_ORDER . " SET payment_id = ? WHERE checkout_id = ?";
        $stmt = $conn->prepare($updateCheckoutOrderQuery);
        $stmt->bind_param("ss", $payment_id, $checkoutId);
        $stmt->execute();
        $stmt->close();

        // Return a success response
        echo json_encode(['success' => true, 'message' => 'Checkout data updated successfully']);
    } else {
        // Handle invalid data
        echo json_encode(['success' => false, 'message' => 'Invalid data']);
    }

    // Close the database connection
    $conn->close();
}

?>
