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

    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Decode the JSON data received in the request body
        $requestData = json_decode(file_get_contents('php://input'), true);

        // Check if checkoutId is present in the decoded data
        //for checkoutId based deletion
        if (isset($requestData['checkout_id'])) {
            // Sanitize and validate the checkoutId (you may need to use prepared statements)
            $checkoutId = mysqli_real_escape_string($conn, $requestData['checkout_id']);

            // Replace 'your_checkout_order_table' with your actual checkout_order table name
            $deleteCheckoutOrderQuery = "DELETE FROM " . TABLE_CHECKOUT_ORDER . " WHERE checkout_id = '$checkoutId'";

            // Execute the delete query for checkout_order table
            if (mysqli_query($conn, $deleteCheckoutOrderQuery)) {
                // Now, delete the checkout row from the main checkout table
                $deleteCheckoutQuery = "DELETE FROM " . TABLE_CHECKOUT . " WHERE checkout_id = '$checkoutId'";

                // Execute the delete query for the main checkout table
                if (mysqli_query($conn, $deleteCheckoutQuery)) {
                    $response = ['success' => true, 'message' => 'Checkout and related orders deleted successfully', "checkoutId" => $checkoutId];
                } else {
                    $response = ['success' => false, 'message' => 'Error deleting checkout: ' . mysqli_error($conn)];
                }
            } else {
                $response = ['success' => false, 'message' => 'Error deleting checkout orders: ' . mysqli_error($conn)];
            }
        } else {
            $response = ['success' => false, 'message' => 'checkoutId not provided'];
        }

        //for order id based deletion
        if (isset($requestData['order_id'])) {
            // Sanitize and validate the order_id (you may need to use prepared statements)
            $orderId = mysqli_real_escape_string($conn, $requestData['order_id']);

            // Replace 'your_customer_order_table' with your actual customer_order table name
            $deleteOrderQuery = "DELETE FROM " . TABLE_CUSTOMER_ORDER . " WHERE order_id = '$orderId'";

            // Execute the delete query for customer_order table
            if (mysqli_query($conn, $deleteOrderQuery)) {
                $response = ['success' => true, 'message' => 'Order deleted successfully', "orderId" => $orderId];
            } else {
                $response = ['success' => false, 'message' => 'Error deleting order: ' . mysqli_error($conn)];
            }
        } else {
            $response = ['success' => false, 'message' => 'orderId not provided'];
        }

        
    } else {
        $response = ['success' => false, 'message' => 'Invalid request method'];
    }

    // Send the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);

    // Close the database connection
    mysqli_close($conn);

?>
