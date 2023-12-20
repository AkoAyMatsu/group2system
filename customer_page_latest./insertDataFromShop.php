<?php

session_start();

$host = "localhost";
$user_db = "root";
$pass_db = "";
$name_db = "bwrs";

$orderTable = "customer_order"; // Replace with your actual order table name
$checkoutTable = "checkout";
$checkoutOrderTable = "checkout_order";
$paymentTable = "payment";

$conn = mysqli_connect($host, $user_db, $pass_db, $name_db);

// Check the connection
if ($conn->connect_error) {
    die(json_encode(["success" => false, "error" => "Connection failed: " . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $data = file_get_contents("php://input");

        // Check if data is empty
        if (empty($data)) {
            throw new Exception("Empty JSON");
        }

        // Decode JSON data
        $order_information = json_decode($data, true);

        // Check if JSON decoding was successful
        if ($order_information === null) {
            throw new Exception("Invalid JSON input");
        }

        // Extract data from order_information
        $order_quantity = $order_information["order_quantity"];
        $overall_price = $order_information["overall_price"];
        $order_type = $order_information["order_type"];
        $order_date = $order_information["order_date"];
        $product_id = $order_information["product_id"];
        $order_status = $order_information["order_status"];
        $payment_id = $order_information["payment_id"];
        $checkout_id = $order_information["checkout_id"];
        $overall_items = $order_information["overall_items"];
        $user_id = $order_information["user_id"];
        $payment_method = $order_information["payment_method"];
        $checkout_date = $order_information["dates"]["checkout_date"];
        $payment_date = $order_information["dates"]["payment_date"];
        $order_id = $order_information["order_id"];
        
        // Check if required fields are present
        if (empty($order_quantity) || empty($overall_price) || empty($order_type) || empty($order_date) || empty($product_id) || empty($order_status) || empty($payment_id) || empty($checkout_id) || empty($overall_items) || empty($user_id) || empty($payment_method) || empty($checkout_date) || empty($payment_date) || empty($order_id)) {
            throw new Exception("Missing required data");
        }

        // Update customer_order table
        $updateOrderQuery = "UPDATE $orderTable 
                             SET order_status = '$order_status', payment_id = '$payment_id' 
                             WHERE order_id = '$order_id'";
        
        if (!$conn->query($updateOrderQuery)) {
            throw new Exception("Error updating customer_order: " . $conn->error);
        }

        // Insert into checkout table
        $insertCheckoutQuery = "INSERT INTO $checkoutTable (checkout_id, checkout_date, total_items, overall_price, user_id, payment_id) 
                                VALUES ('$checkout_id', '$checkout_date', '$overall_items', '$overall_price', '$user_id', '$payment_id')";
        
        if (!$conn->query($insertCheckoutQuery)) {
            throw new Exception("Error inserting into checkout: " . $conn->error);
        }

        // Insert into checkout_order table
        $insertCheckoutOrderQuery = "INSERT INTO $checkoutOrderTable (checkout_id, order_id, user_id, product_id, payment_id) 
                                     VALUES ('$checkout_id', '$order_id', '$user_id', '$product_id', '$payment_id')";
        
        if (!$conn->query($insertCheckoutOrderQuery)) {
            throw new Exception("Error inserting into checkout_order: " . $conn->error);
        }

        // Insert into payment table
        $insertPaymentQuery = "INSERT INTO $paymentTable (payment_id, checkout_id, payment_type, payment_total, payment_date) 
                               VALUES ('$payment_id', '$checkout_id', '$payment_method', '$overall_price', '$payment_date')";
        
        if (!$conn->query($insertPaymentQuery)) {
            throw new Exception("Error inserting into payment: " . $conn->error);
        }

        echo json_encode(["success" => true, "msg" => "Order placed successfully!"]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid request method"]);
}

$conn->close();

?>
