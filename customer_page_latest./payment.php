<?php

session_start();
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

// Assuming your payment table is named "payment"
define("TABLE_PAYMENT", "payment");
define("TABLE_CUSTOMER_ORDER", "customer_order");
define("TABLE_CHECKOUT", "checkout");
define("TABLE_CHECKOUT_ORDER", "checkout_order");
define("TABLE_PRODUCT", "products");

// Get the JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);

if(isset($_SESSION['user_id'])){
    $current_user_id = $_SESSION['user_id'];

        // Check if the data is valid
    if ($data && isset($data['payment_id'], $data['payment_type'], $data['payment_total'], $data['payment_date'])) {
        $payment_id = $data['payment_id'];
        $payment_type = $data['payment_type'];
        $payment_total = $data['payment_total'];
        $payment_date = $data['payment_date'];
        $allOrderIds = $data['order_ids'];
        $checkoutId = $data['checkout_id'];

        $orderStatus = "Pending";

        // Format date if needed
        // $formatted_checkout_date = date("Y-m-d H:i:s", strtotime($checkout_date));

        // Update customer_order table with payment_id
        foreach ($allOrderIds as $orderId) {
            $updateCustomerOrderQuery = "UPDATE " . TABLE_CUSTOMER_ORDER . " SET payment_id = ?, order_status = ? WHERE order_id = ?";
            $stmt = $conn->prepare($updateCustomerOrderQuery);
            $stmt->bind_param("sss", $payment_id, $orderStatus, $orderId);
            $stmt->execute();
            $stmt->close();
        }

        // Update checkout table with payment_id
        $updateCheckoutQuery = "UPDATE " . TABLE_CHECKOUT . " SET payment_id = ? WHERE checkout_id = ? ";
        $stmt = $conn->prepare($updateCheckoutQuery);
        $stmt->bind_param("ss", $payment_id, $checkoutId);
        $stmt->execute();
        $stmt->close();

        // Update checkout_order table with payment_id\
        $checkoutOrderIds = implode(",", $allOrderIds);
        $updateCheckoutOrderQuery = "UPDATE " . TABLE_CHECKOUT_ORDER . " SET payment_id = ? WHERE checkout_id = ?";
        $stmt = $conn->prepare($updateCheckoutOrderQuery);
        $stmt->bind_param("ss", $payment_id, $checkoutId);
        $stmt->execute();
        $stmt->close();

        // Insert data into the payment table
        $insertPaymentQuery = "INSERT INTO " . TABLE_PAYMENT . " (payment_id, payment_total, payment_date, payment_type, checkout_id) 
                            VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertPaymentQuery);
        $stmt->bind_param("sdsss", $payment_id, $payment_total, $payment_date, $payment_type, $checkoutId);
        $stmt->execute();
        $stmt->close();

        $updatedData = [];
        $sql_order = "SELECT co.order_type, co.user_id, co.order_date, co.total_price, co.order_quantity, co.order_status, co.order_id, p.product_id, p.product_quantity, p.product_img, p.product_type, p.product_buy_price, p.product_refill_price, p.product_borrow_price
                FROM " . TABLE_CUSTOMER_ORDER . " co
                JOIN " . TABLE_PRODUCT . " p ON co.product_id = p.product_id
                WHERE co.user_id = $current_user_id AND co.order_id IN ($checkoutOrderIds)";

            $result = $conn->query($sql_order);

            // Check if there are results
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    $updatedData[] = $row;
                }
            } else {
                echo "No results found";
            }

        // Return a success response
        echo json_encode([
            'success' => true, 
            'message' => 'Payment processed successfully', 
            "updatedData" => $updatedData, 
            "payment_total" => $payment_total, 
            "payment_date" => $payment_date, 
            "checkoutId" => $checkoutId,
            "allOrderIds" => $allOrderIds]);
    } else {
        // Handle invalid data
        echo json_encode(['success' => false, 'message' => 'Invalid data']);
    }

    // Close the database connection
    $conn->close();
}


?>
