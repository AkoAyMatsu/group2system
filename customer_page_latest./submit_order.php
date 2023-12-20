<?php

$host = "localhost";
$user_db = "root";
$pass_db = "";
$name_db = "bwrs";
$orderTable = "customer_order"; // Replace with your actual order table name
$productTable = "products"; // Replace with your actual products table name

$conn = mysqli_connect($host, $user_db, $pass_db, $name_db);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "error" => "Connection failed: " . $conn->connect_error]));
}

function genOrderId($prefix_id) {
    $generateRandomNumber = str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);
    $order_id = $prefix_id . $generateRandomNumber;
    return $order_id;
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $data = file_get_contents("php://input");

            // Specify CORS headers
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');

            if (empty($data)) {
                throw new Exception("Empty JSON");
            }

            $order_Info = json_decode($data, true);

            if ($order_Info === null) {
                throw new Exception("Invalid JSON input");
            }

            $order_quantity = $order_Info["order_quantity"] ?? null;
            $total_price = $order_Info["total_price"] ?? null;
            $order_type = $order_Info["order_type"] ?? null;
            $order_date = $order_Info["order_date"] ?? null;
            $product_id = $order_Info["product_id"] ?? null;
            $order_status = $order_Info["order_status"] ?? null;

            if (!$order_quantity || !$total_price || !$order_type || !$order_date || !$product_id || !$order_status) {
                throw new Exception("Invalid data received");
            }

            $order_id = genOrderId("100");

            // Insert into customer_order table
            $sql_query = "INSERT INTO $orderTable (order_quantity, total_price, order_type, order_date, product_id, order_status, order_id, user_id) 
                VALUES ('$order_quantity', '$total_price', '$order_type', '$order_date', '$product_id', '$order_status', '$order_id', '$user_id')";

            if ($conn->query($sql_query) === TRUE) {
                // Fetch data from customer_order and products tables based on product_id
                $select_query = "
                    SELECT $orderTable.*, $productTable.*
                    FROM $orderTable
                    JOIN $productTable ON $orderTable.product_id = $productTable.product_id
                    WHERE $orderTable.order_id = '$order_id'
                ";

                $result = $conn->query($select_query);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo json_encode([
                        "success" => true,
                        "msg" => "Order saved successfully!",
                        "order_data" => $row
                    ]);
                } else {
                    echo json_encode([
                        "success" => true,
                        "msg" => "Order saved successfully, but unable to fetch order data."
                    ]);
                }
            } else {
                throw new Exception($conn->error);
            }
        } catch (Exception $e) {
            echo json_encode(["success" => false, "error" => $e->getMessage()]);
        }
    } else {
        //echo json_encode(["success" => false, "error" => "Invalid request method"]);
    }
} else {
    echo json_encode(["success" => false, "error" => "User not authenticated"]);
}

$conn->close();
?>
