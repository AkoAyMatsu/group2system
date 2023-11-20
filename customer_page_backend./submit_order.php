<?php

// Start or resume a session
session_start();

$host = "localhost";
$user_db = "root";
$pass_db = "";
$name_db = "bwrs";
$orderTable = "customer_order"; // Replace with your actual order table name

// Function to generate order ID
function genOrderId($prefix_id){
    $generateRandomNumber = str_pad(mt_rand(1, 999), 5, '0', STR_PAD_LEFT);
    return $prefix_id . $generateRandomNumber;
}

// Establish database connection
$conn = new mysqli($host, $user_db, $pass_db, $name_db);
if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit();
}

// Process POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type");

    $data = file_get_contents("php://input");
    $order_info = json_decode($data, true);

    //$user_id = 20100689;

    // Check if the user is logged in
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        echo json_encode(["success" => true, "user_id" => $user_id]);
        // Validate and sanitize input data
        if (isset($user_id, $order_info['order_date'], $order_info['product_id'], $order_info['total_price'], $order_info['order_type'])) {
            $order_id = genOrderId("100");

            // Use prepared statement to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO $orderTable (order_quantity, total_price, order_type, order_date, product_id, order_status, order_id, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

            // Bind parameters
            $stmt->bind_param("dssssssd", $order_info['order_quantity'], $order_info['total_price'], $order_info['order_type'], $order_info['order_date'], $order_info['product_id'], $order_info['order_status'], $order_id, $user_id);

            // Execute the statement
            if ($stmt->execute()) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false, "error" => $stmt->error]);
            }

            $stmt->close();
        } else {
            echo json_encode(["error" => "Incomplete or invalid data received"]);
        }
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}

// Close the database connection
$conn->close();
?>
