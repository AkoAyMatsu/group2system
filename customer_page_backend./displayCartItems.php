<?php

    $host = 'localhost';
    $user_db = 'root';
    $pass_db = '';
    $name_db = 'bwrs';


    $conn = new mysqli($host, $user_db, $pass_db, $name_db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    try {
        $username = "";
    
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
                        WHERE co.user_id = $userId AND co.order_status = 'In Cart'";
            $result = $conn->query($sql_order);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                    <td class="col-sm-2 col-md-1">
                        <div class="form-check text-sm-center text-md-center text-lg-center text-xl-center text-xxl-center">
                            <input class="form-check-input mx-sm-0 me-sm-4 mx-lg-3 me-lg-5 fs-1 border-5 border-gray box-size" type="checkbox" value="" id="flexCheckDefault">
                        </div> 
                    </td>
                    <td>
                        <div class="container-fluid p-5 mt-1">
                            <div class="container-fluid bg-primary me-5 pt-md-4 w-100 h-100 d-md-inline-flex d-sm-block border-3 rounded-3 text-sm-center text-center rg--container">
                                
                                <div class="pb-3 px-2 img--container">
                                    <img src="<?php echo '../'. $row['product_img']?>" alt="" class="p-2 pb-md-1 mb-md-2 img-fluid rd--gallon">
                                </div>
                                    <div class="rd--container mb-0 mb-sm-1 py-0 py-md-0 mt-md-0">
                                        <div class="h5 mx-md-0 ms-md-0 my-md-3 text-md-start fw-bold"><?php echo $row['product_type']?></div>
                                        <div class="h5 mx-sm ms-md-auto d-md-flex justify-content-md-start">
                                            <span class="h5 mx-sm-0 fw-bold">Php</span>
                                            <span class="h5 px-1 px-sm-1 fw-bold roundPrice">
                                                <?php
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
                                                    $truePrice = $price;
                                                    
                                                    echo $truePrice;
                                                ?>
                                            </span>
                                        </div>
                                        
                                        <div class="py-3 py-md-1 mx-sm-3 mt-md-5 ms-md-auto d-sm-flex justify-content-sm-center d-md-flex justify-content-md-start d-flex justify-content-center select--option">
                                            <select class="form-select text-bg-info fs-5 w-50 h-25 round--order--select" aria-label="Default select example">
                                                <option value="Buy" <?php echo ($row['order_type'] === 'Buy') ? 'selected' : ''; ?>>Buy</option>
                                                <option value="Refill" <?php echo ($row['order_type'] === 'Refill') ? 'selected' : ''; ?>>Refill</option>
                                                <option value="Borrow" <?php echo ($row['order_type'] === 'Borrow') ? 'selected' : ''; ?>>Borrow</option>
                                            </select>
                                            <div class="d-inline-flex">
                                                <div>
                                                    <button class="btn btn-light mx-1 ms-md-3 mx-md-1 py-1 min--rd">
                                                        <div class="bi bi-dash fs-5 mt-1"></div>
                                                    </button>
                                                    
                                                </div>
                                                <span class="bg bg-light px-4 rounded-2 fs-3 py-0 w-50 ms-md-0 quantity--round">
                                                    <?php echo $row['order_quantity'];?>
                                                </span>
                                                <button class="btn btn-light mx-1 ms-md-1 mx-md-2 py-1 min--rd">
                                                    <div class="bi bi-plus fs-5 mt-1"></div>
                                                </button>
                                            </div>
                                        </div>
                                    </div>   
                                </div>
                            </div>
                        </td>
                        </tr>
                    <?php
                }
            } else {
                echo '<tr><td colspan="2" class="text-center fw-bold h5">No items found with order_status "In Cart"</td></tr>';
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