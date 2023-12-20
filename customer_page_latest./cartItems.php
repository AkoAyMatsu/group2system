<?php

    $host = 'localhost';
    $user_db = 'root';
    $pass_db = '';
    $name_db = 'bwrs';


    $conn = new mysqli($host, $user_db, $pass_db, $name_db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $itemsArray = [];

    try {
        // Check if userId is set in the session
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
    
            $tableName = "customer";
            $orderTable = "customer_order";
            $productTable = "products";

            // Fetch user data from the database using the retrieved userId from the session
            $sql_order = "SELECT co.order_type, co.user_id, co.order_date, co.total_price, co.order_quantity, co.order_status, co.order_id, p.product_id, p.product_quantity, p.product_img, p.product_type, p.product_buy_price, p.product_refill_price, p.product_borrow_price
                        FROM $orderTable co
                        JOIN $productTable p ON co.product_id = p.product_id
                        WHERE co.user_id = $userId AND co.order_status = 'In Cart'";
            $result = $conn->query($sql_order);
             // Initialize an array to store items data

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $itemsArray[] = $row; // Add each row to the array
                }
            } else {
                echo '<tr>
                        <td colspan="2" class="text-center fw-bold h4">
                            <img src="empty_cart.png" alt="" width=150 height=150> 
                            <div>NO ITEMS IN YOUR CART</div>
                        </td>
                      </tr>';
            }
        } else {
            // Redirect to login page or handle the situation where the user is not logged in
        }
    } catch (Exception $e) {
        // Handle any unexpected exceptions
        echo "Error: " . $e->getMessage();
    } finally {
        // Close the database connection
        $conn->close();
    }

?>