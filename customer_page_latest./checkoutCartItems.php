<?php
// Start the session
session_start();

// Assuming you have a database connection
$servername = "localhost";
$username = "root";
$password = ""; // Assuming no password
$dbname = "bwrs";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

define("TABLE_CUSTOMER_ORDER", "customer_order");
define("TABLE_CHECKOUT", "checkout");
define("TABLE_CHECKOUT_ORDER", "checkout_order");
define("TABLE_PRODUCT", "products");

function generateCheckoutId($prefix){
    $generateRandomNumber = str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);
    $checkout_id = $prefix . $generateRandomNumber;
    return $checkout_id;
}

if (isset($_SESSION['user_id'])){
    // Get the JSON data from the request
    $current_user_id = $_SESSION['user_id'];
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if the data is valid
    if ($data && isset($data['cart-item']) && is_array($data['cart-item'])) {
        $checkout_id_prefix = "101";
        $checkoutId = generateCheckoutId($checkout_id_prefix);

        $overallItems = $data['overallItems'];
        $overallPrice = number_format($data['overallPrice'], 2, '.', '');

        $orderIds = [];

        // Loop through each item in the cart
        foreach ($data['cart-item'] as $item) {
            $orderId = $item['orderId'];
            $orderIds[] = $orderId;

            $quantity = $item['quantity'];
            $totalPrice = number_format($item['totalPrice'], 2, '.', '');
            $productId = $item['productId'];

            // Update the database with the new quantity and total price
            $stmt = $conn->prepare("UPDATE " . TABLE_CUSTOMER_ORDER . " SET order_quantity = ?, total_price = ? WHERE order_id = ?");
            $stmt->bind_param("idi", $quantity, $totalPrice, $orderId);
            $stmt->execute();
            $stmt->close();

            // Insert into checkout_order table
            $insertCheckoutOrderQuery = "INSERT INTO " . TABLE_CHECKOUT_ORDER . " (checkout_id, order_id, user_id, product_id) 
                                        VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insertCheckoutOrderQuery);
            $stmt->bind_param("siii", $checkoutId, $orderId, $current_user_id, $productId);
            $stmt->execute();
            $stmt->close();
        }
        
        $checkoutDate = $data['checkoutDate'];

        // Save checkout information in the checkout table
        $insertCheckoutQuery = "INSERT INTO " . TABLE_CHECKOUT . " (checkout_id, checkout_date, user_id, total_items, overall_price) 
                                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertCheckoutQuery);
        $stmt->bind_param("ssidd", $checkoutId, $checkoutDate, $current_user_id, $overallItems, $overallPrice);
        $stmt->execute();
        $stmt->close();

        // Fetch the updated data from the database
        $updatedData = [];
        $selectedOrderIds = implode(',', $orderIds);

        // Fetch the latest checkout_id from checkout table
        $latestCheckoutIdQuery = "SELECT checkout_id FROM " . TABLE_CHECKOUT . " WHERE user_id = $current_user_id ORDER BY checkout_date DESC LIMIT 1";
        $latestCheckoutIdResult = $conn->query($latestCheckoutIdQuery);

        // Check if there are results
        if ($latestCheckoutIdResult->num_rows > 0) {
            $row = $latestCheckoutIdResult->fetch_assoc();
            $latestCheckoutId = $row['checkout_id'];
        } else {
            // If no checkout_id is found, handle accordingly (throw an error, set to default, etc.)
            $latestCheckoutId = null;
        }

        // Fetch all order_ids for a specific checkout_id from checkout_order table
        $allOrderIdsQuery = "SELECT order_id, product_id, user_id FROM " . TABLE_CHECKOUT_ORDER . " WHERE checkout_id = '$checkoutId'";
        $allOrderIdsResult = $conn->query($allOrderIdsQuery);

        // Check if there are results
        $allOrderIds = [];

        if ($allOrderIdsResult->num_rows > 0) {
            while ($row = $allOrderIdsResult->fetch_assoc()) {
                $allOrderIds[] = $row['order_id'];
            }
        } else {
            // If no order_ids are found, handle accordingly (empty array, set to default, etc.)
        }

        $sql_order = "SELECT co.order_type, co.user_id, co.order_date, co.total_price, co.order_quantity, co.order_status, co.order_id, p.product_id, p.product_quantity, p.product_img, p.product_type, p.product_buy_price, p.product_refill_price, p.product_borrow_price
            FROM " . TABLE_CUSTOMER_ORDER . " co
            JOIN " . TABLE_PRODUCT . " p ON co.product_id = p.product_id
            WHERE co.user_id = $current_user_id AND co.order_id IN ($selectedOrderIds)";

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

        // Close the database connection
        $conn->close();

        // Regenerate session ID
        session_regenerate_id();

        $_SESSION['selectedOrderIds'] = $orderIds;
        $_SESSION['itemsToCheckout']  = $overallItems;
        $_SESSION['priceToCheckout'] = $overallPrice;
        $_SESSION['dateOfCheckout'] = $checkoutDate;

        // Return a success response with the updated data
        echo json_encode([
            'success' => true, 
            'message' => 'Items checked out successfully', 
            'updatedData' => $updatedData, 
            'overallItems' => $overallItems, 
            'overallPrice' => $overallPrice, 
            'checkoutId' => $checkoutId,
            'allOrderIds' => $allOrderIds,
            'checkoutDate' => $checkoutDate]);
        exit;

        

       

        
    } else {
        // Handle invalid data
        echo json_encode(['success' => false, 'message' => 'Invalid data']);
    }

    // Close the database connection
    $conn->close();

}
?>
