<?php

$host = "localhost";
$user_db = "root";
$pass_db = "";
$name_db = "bwrs";
$orderTable = "customer_order"; // Replace with your actual order table name

$conn = mysqli_connect($host, $user_db, $pass_db, $name_db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
function genOrderId($prefix_id){
    $generateRandomNumber = str_pad(mt_rand(1, 999), 5, '0', STR_PAD_LEFT);
    $order_id = $prefix_id . $generateRandomNumber;
    return $order_id;
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    echo json_encode(["success" => true]);

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = file_get_contents("php://input");

        error_log('Received data: ' . file_get_contents("php://input"));
        echo 'Received data: ' . $data;

        if (!empty($data)) {
            $order_Info = json_decode($data, true);

            if ($order_Info !== null) {
                $order_quantity = $order_Info["order_quantity"];
                $total_price = $order_Info["total_price"];
                $order_type = $order_Info["order_type"];
                $order_date = $order_Info["order_date"];
                $product_id = $order_Info["product_id"];
                $order_status = $order_Info["order_status"];
                $order_id = genOrderId("100");

                echo json_encode($order_Info);

                if (isset($user_id) && isset($order_date) && isset($product_id) && isset($total_price) && isset($order_type) && isset($order_id) && isset($order_status) && isset($order_quantity)) {
                    $sql_query = "INSERT INTO $orderTable (order_quantity, total_price, order_type, order_date, product_id, order_status, order_id, user_id) 
                        VALUES ('$order_quantity', '$total_price', '$order_type', '$order_date', '$product_id', '$order_status', '$order_id', '$user_id')";

                    if ($conn->query($sql_query) === TRUE) {
                        echo '<script>console.log("Order saved successfully!")</script>';
                        echo json_encode(["success" => true]); // Send JSON response for success
                    } else {
                        echo '<script>console.error("Error: ' . $conn->error . '");</script>';
                        echo json_encode(["success" => false, "error" => $conn->error]);
                    }
                } else {
                    echo ' <script>console.error("Order not saved successfully")</script>';
                }
            } else {
                // Handle JSON decoding error
                echo '<script>console.error("Invalid JSON input!")</script>';
                //echo json_encode(["error" => "Invalid JSON input"]);
            }
        } else {
            echo  '<script>console.error("JSON is empty!")</script>';
        }
    } else {
        echo '<script>console.log("Invalid request method")</script>';
    }
}



$conn->close();
?>
