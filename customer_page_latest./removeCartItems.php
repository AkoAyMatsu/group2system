<?php
// Start the session
session_start();

// Assuming you have a database connection
$servername = "localhost";
$username = "root";
$password = ""; // Assuming no password
$dbname = "bwrs";
$tableName = "customer_order";

// Create a response array
$response = ['success' => false, 'message' => ''];

try {
    // Check if user_id is set in the session
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Get selected order IDs from the POST data
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (isset($data['orderIds']) && is_array($data['orderIds'])) {
            
            $selectedOrderIds = $data['orderIds'];
            // Create a database connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check the connection
            if ($conn->connect_error) {
                throw new Exception("Connection failed: " . $conn->connect_error);
            }

            // Prepare and execute the SQL query to remove items based on selected order IDs and user ID
            $stmt = $conn->prepare("DELETE FROM $tableName WHERE order_id = ? AND user_id = ?");
            $stmt->bind_param("ii", $orderId, $user_id);

            foreach ($selectedOrderIds as $orderId) {
                $stmt->execute();
            }

            // Check if the SQL queries were successful
            if ($stmt->errno) {
                throw new Exception("Error executing SQL query: " . $stmt->error);
            }

            // Close the prepared statement and database connection
            $stmt->close();
            $conn->close();

            // Update the response
            $response['success'] = true;
            $response['message'] = 'Items removed successfully';
        } else {
            throw new Exception("Invalid or missing order IDs in the request.");
        }
    } else {
        throw new Exception("User ID not set in the session.");
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

// Return the JSON response
echo json_encode($response);
?>
