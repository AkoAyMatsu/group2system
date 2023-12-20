<?php
session_start();

$host = "localhost";
$user_db = "root";
$pass_db = "";
$name_db = "bwrs";

$orderTable = "customer_order";
$checkoutTable = "checkout";
$checkoutOrderTable = "checkout_order";
$paymentTable = "payment";

$conn = mysqli_connect($host, $user_db, $pass_db, $name_db);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "error" => "Connection failed: " . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $data = file_get_contents("php://input");

        if (empty($data)) {
            throw new Exception("Empty JSON");
        }

        $cancelData = json_decode($data, true);

        if ($cancelData === null) {
            throw new Exception("Invalid JSON input");
        }

        // Extract data from cancelData
        $checkout_id = $cancelData["checkout_id"];
        $order_ids = $cancelData["order_ids"];
        $payment_ids = $cancelData["payment_ids"];
        
        $cancelledStatus = "Cancelled";

        // Update order status to "Cancelled" in customer_order table
        $updateOrderStatusQuery = "UPDATE $orderTable SET order_status = '$cancelledStatus' WHERE order_id IN ('" . implode("','", $order_ids) . "')";
        if (!$conn->query($updateOrderStatusQuery)) {
            throw new Exception($conn->error);
        }

        // Select cancelled items from customer_order table
        $selectCancelledItemsQuery = "SELECT * FROM $orderTable WHERE order_id IN ('" . implode("','", $order_ids) . "') AND order_status = 'Cancelled'";
        $cancelledItemsResult = $conn->query($selectCancelledItemsQuery);

        $cancelledItems = [];
        while ($row = $cancelledItemsResult->fetch_assoc()) {
            $cancelledItems[] = $row;
        }

        
        // Delete data from payment, checkout, and checkout_order tables
        $deletePaymentQuery = "DELETE FROM $paymentTable WHERE payment_id IN ('" . implode("','", $payment_ids) . "')";
        $deleteCheckoutOrderQuery = "DELETE FROM $checkoutOrderTable WHERE order_id IN ('" . implode("','", $order_ids) . "')";
        $deleteCheckoutQuery = "DELETE FROM $checkoutTable WHERE checkout_id IN ('" . implode("','", $checkout_id) . "')";

        if (!$conn->query($deletePaymentQuery) || !$conn->query($deleteCheckoutOrderQuery) || !$conn->query($deleteCheckoutQuery)) {
            throw new Exception($conn->error);
        }

        

        echo json_encode([
            "success" => true, 
            "msg" => "Order cancelled successfully!",
            "cancelled_items" => $cancelledItems]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid request method"]);
}

$conn->close();
?>
