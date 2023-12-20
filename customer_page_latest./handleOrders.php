<?php

$host = "localhost";
$user_db = "root";
$pass_db = "";
$name_db = "bwrs";

$conn = mysqli_connect($host, $user_db, $pass_db, $name_db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

try {
    // Check if userId is set in the session
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        $tableName = "customer";
        $orderTable = "customer_order";
        $productTable = "products";

        // Fetch user data from the database using the retrieved userId from the session
        $sql_order = "SELECT co.order_type, co.order_date, co.total_price, co.order_quantity, co.order_status, p.product_id, p.product_quantity, p.product_img, p.product_type, p.product_buy_price, p.product_refill_price, p.product_borrow_price
                      FROM $orderTable co
                      JOIN $productTable p ON co.product_id = p.product_id
                      WHERE co.user_id = $userId";
        
        $result = $conn->query($sql_order);

        if ($result) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td class="d-flex">
                            <img src="' . '../' . $row['product_img'] . '" alt="" srcset="" class="rounded--gallon">
                            <h5 class="px-2 product--text">' . $row['product_type'] . '</h5>
                          </td>';
                    echo '<td class="py-5">' . $row['order_type'] .'</td>';
                    echo '<td class="py-5">' . $row['order_date']. '</td>';

                    // Use conditional statements to determine the price based on order type
                    $price = 0;
                    switch ($row['order_type']) {
                        case 'Buy':
                            $price = $row['product_buy_price'];

                            break;
                        case 'Refill':
                            $price = $row['product_refill_price'];
                            break;
                        case 'Borrow':
                            $price = $row['product_borrow_price'];
                            break;
                        default:
                            // Handle other cases or set a default value
                            break;
                    }
                    $truePrice = "Php" . ' ' . $price;

                    // Update product_quantity for buy or borrow orders
                    /*if ($row['order_type'] === 'Buy' || $row['order_type'] === 'Borrow') {
                        $newQuantity = $row['product_quantity'] - $row['order_quantity'];

                        // Update product_quantity in the products table
                        $updateProductQuantity = "UPDATE $productTable SET product_quantity = $newQuantity WHERE product_id = {$row['product_id']}";
                        $conn->query($updateProductQuantity);
                    }*/

                    echo '<td class="py-5">' .$truePrice. '</td>';
                    echo '<td class="py-5">' . $row['order_quantity']. '</td>';
                    echo '<td class="py-5">' . 'Php '. number_format($row['total_price'],2) . '</td>';
                    echo '<td class="py-5">' . $row['order_status']. '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr>
                        <td colspan="7" class="fw-bold text-center">
                            <img src="clipboard_x.png" alt="" width=150 height=150>
                            <div class="h4 fw-bold">NO HISTORIES FOUND</div>
                        </td>  
                      </tr>';
            }
        } else {
            throw new Exception("Error in executing the query: " . $conn->error);
        }
    } else {
        // Redirect to login page or handle the situation where the user is not logged in
    }
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
} finally {
    // Close the database connection
    if ($conn) {
        $conn->close();
    }
}
?>
