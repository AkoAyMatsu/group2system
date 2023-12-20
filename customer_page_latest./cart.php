<?php

require "handleDash.php";



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="stylesheet" href="cart.css">
</head>
<body>
    <nav class="navbar bg-primary">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon fs-5"></span>
            </button>
            <a class="navbar-brand text-light fs-5 me-auto fw-semibold d-sm-none d-md-flex company--name" href="#">BANI WATER REFILLING STATION</a>
            <!--Dropdown for user logout-->
                <div class="dropdown user--dropdown">
                    <button class="btn btn-outline-light user--button" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="bi bi-person-circle fs-3 user--icon"></span>
                        <span class="px-2 fs-5 user--name">
                            <?php
                                echo $username;
                            ?>
                        </span>
                        <span class="dropdown dropdown-toggle fs-3 dropdown--icon"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end user--dropdown--list fs-5">
                        <li>
                            <a class="dropdown-item" href="profile.php">Profile
                                <span class="bi bi-person-circle fs-3 px-1 dp-icons"></span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="cart.php">My Cart
                                <span class="bi bi-cart fs-3 px-1 dp-icons"></span>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li class="">
                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutModal" href="#">Logout
                                <span class="bi bi-box-arrow-left fs-3 px-2"></span>
                            </a>
                        </li>
                    </ul>
                </div>
            <!--end of that dropdown-->

            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header canvas--header">
                    <h5 class="offcanvas-title text-dark" id="offcanvasNavbarLabel">Welcome 
                        <?php
                            echo $username;
                        ?>!
                    </h5>
                    <button type="button" class="btn-close close--btn" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <div class="offcanvas-header canvas--header--2">
                    <div class="d-inline-flex align-items-center py-2 justify-content-center rounded-circle bg-primary --user">
                        <img src="<?php echo $user_image;?>" alt="User_Images" class="rounded-circle" width="120px" height="112px">
                    </div>
                    <div class="h5 text-light me-auto px-3 mt-5 --userName" id="username">
                            <?php
                                echo $username;
                            ?>
                        <div class="h5 text-light pt-2">USER ID: <span class="h5 text-light --idNumber" id="id_number">
                            <?php
                                echo $userid;
                            ?>
                        </span></div>
                    </div>
                </div>

                <div class="offcanvas-body canvas--color">
                    <ul class="navbar-nav justify-content-end pe-3 nav--items">
                        <li class="nav-item">
                            <a class="nav-link active fs-5 text-light" aria-current="page" href="dash.php">
                                <span class="bi bi-speedometer2 fs-3 px-2"></span>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active fs-5 text-light" href="shopProducts.php">
                                <span class="bi bi-bag fs-3 px-2"></span>Shop Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active fs-5 text-light" href="cart.php">
                                <span class="bi bi-cart fs-3 px-2"></span>Cart
                            </a>
                        </li>
                        <!--Profile-->
                        <li class="nav-item">
                            <a class="nav-link active fs-5 text-light" href="profile.php">
                                <span class="bi bi-person-circle fs-3 px-2"></span>Profile
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="offcanvas-header canvas--footer">
                    <ul class="navbar-nav justify-content-end pe-3 logout--nav" data-bs-toggle="modal" data-bs-target="#logoutModal">
                        <li class="nav-item d-flex pt-1 py-1 logout--item">
                            <a class="nav-link active fs-5 text-light logout--text" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                <span class="bi bi-box-arrow-left fs-2 px-2 logout--icon"></span>Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <section>
        <div class="container-fluid pt-5 h-100 w-100 mt-1 table--container" id="orderHistory">
            <ul class="nav nav-tabs dash--tabs">
                <li class="nav-item title--place d-flex">
                    <div class="nav-link fs-5 text-bg-dark dash--title" aria-current="page"><a href="cart.php">Cart Items</a></div>
                    <div class="nav-link fs-5 text-bg-dark dash--title" aria-current="page"><a href="order_status.php">Order Status</a></div>
                </li>
            </ul>
            <table class="table table-responsive table-bordered border border-gray border-5 fs-5 dash--table">
                <tbody>
                <?php require "cartItems.php";?>
                <?php foreach($itemsArray as $items):

                    $uniqueCheckboxId = $items['order_id'];

                ?>
                <tr data-order-id="order_id_<?php echo $uniqueCheckboxId?>">
                    <td class="col-sm-2 col-md-1">
                        <div class="form-check text-sm-center text-md-center text-lg-center text-xl-center text-xxl-center">
                            <input class="form-check-input mx-sm-0 me-sm-4 mx-lg-3 me-lg-5 fs-1 border-5 border-gray box-size" type="checkbox" value="" id="item_checkbox_<?php echo $uniqueCheckboxId?>" data-id="order_<?php echo $uniqueCheckboxId?>">
                        </div> 
                    </td>
                    <td>
                        <div class="container-fluid p-5 mt-1">
                            <div class="container-fluid bg-primary me-5 pt-md-4 w-100 h-100 d-md-inline-flex d-sm-block border-3 rounded-3 text-sm-center text-center order--container">
                                
                                <div class="pb-3 px-2 img--container">
                                    <img src="<?php echo '../'. $items['product_img']?>" alt="" class="p-2 pb-md-1 mb-md-2 img-fluid order--gallon"> <!--PRODUCT IMAGGE-->
                                </div>
                                    <div class="rd--container mb-0 mb-sm-1 py-0 py-md-0 mt-md-0">
                                        <div class="h5 mx-md-0 ms-md-0 my-md-3 text-md-start">
                                            <?php echo $items['product_type']; ?>
                                            
                                            <span class="h5 product--id d-none">Product ID: <?php echo $items['product_id']?></span> <!--ID NG PRODUCT-->
                                            
                                        </div>
                                        <div class="h5 mx-sm ms-md-auto d-md-flex justify-content-md-start">
                                            <span class="h5 mx-sm-0">Php</span>
                                            <span class="h5 px-1 px-sm-1 fw-bold totalPrice"> <!--TOTAL PRICE NG ORDER-->
                                                <?php
                                                    echo number_format($items['total_price'], 2, '.', ''); 
                                                ?>
                                            </span>
                                            <div class="py-sm-2 py-md-0 d-sm-block">
                                                <span class="h5">Unit Price:</span>
                                                <span class="h5 fw-bold productPrice"> <!--PRICE NG PRODUCT DEPENDE DOON SA TYPE NG ORDER-->
                                                    <?php
                                                        $price = 0;
                                                            switch ($items['order_type']) {
                                                                case 'Buy':
                                                                    $price = $items['product_buy_price'];
                                                                    break;
                                                                case 'Refill':
                                                                    $price = $items['product_refill_price'];
                                                                    break;
                                                                case 'Borrow':
                                                                    $price = $items['product_borrow_price'];
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
                                        </div>

                                        <span class="h5 order--item d-none">Order ID: <?php echo $items['order_id']?></span>
                                        <span class="h5 user--id d-none">User ID: <?php echo $items['user_id']?></span>
                                        

                                        <div class="py-3 py-md-1 mx-sm-3 mt-md-5 ms-md-auto d-sm-flex justify-content-sm-center d-md-flex justify-content-md-start d-flex justify-content-center select--option">
                                            <select class="form-select text-bg-info fs-5 w-50 h-25 order--select" aria-label="Default select example">
                                                <?php
                                                    $orderType = $items['order_type']; // Assuming $row is available in this context

                                                    // Display the selected option based on the order type
                                                    switch ($orderType) {
                                                        case 'Buy':
                                                            echo '<option value="Buy" selected>Buy</option>';
                                                            break;
                                                        case 'Refill':
                                                            echo '<option value="Refill" selected>Refill</option>';
                                                            break;
                                                        case 'Borrow':
                                                            echo '<option value="Borrow" selected>Borrow</option>';
                                                            break;
                                                    }
                                                ?>

                                            </select>
                                            <div class="d-inline-flex">
                                                <div>
                                                    <button class="btn btn-light mx-1 ms-md-3 mx-md-1 py-1 min--order" id="min_<?php echo $uniqueCheckboxId?>" >
                                                        <div class="bi bi-dash fs-5 mt-1"></div>
                                                    </button>
                                                </div>
                                                <span class="bg bg-light px-4 rounded-2 fs-3 py-0 w-50 ms-md-0 quantity--order">
                                                    <?php echo $items['order_quantity'];?> <!--QUANTITY NG ORDER-->
                                                </span>
                                                <button class="btn btn-light mx-1 ms-md-1 mx-md-2 py-1 add--order">
                                                    <div class="bi bi-plus fs-5 mt-1"></div>
                                                </button>
                                            </div>
                                        </div>
                                    </div>   
                                </div>
                            </div>
                        </td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>

            <div class="container-fluid">
                <div class="container-fluid d-flex">
                    <input class="form-check-input mb-2 mb-sm-2 mt-3 fs-1 border-5 border-gray box--size" type="checkbox" value="" id="checkAllBoxes">
                    <div class="h5 mt-3 mt-sm-4 mt-md-4 all--text">All</div>
                    <button class="btn btn-danger ms-auto d-md-inline-flex h-25 mt-3 fs-5 mt-lg-3 btn-lg removeButton" disabled="true" data-selected-count="0" data-bs-toggle="modal" data-bs-target="#removeModal">
                        <span class="h6 d-sm-none d-md-inline mt-md-1 px-md-1">Remove</span>
                        <span class="bi bi-trash"></span>
                    </button> 
                    <div class="mt-3 py-1 h5 ms-auto">
                        Total
                        <span class="h5 fw-bold px-0">Php</span>
                        <span class="h5 fw-bold pe-4 totalItemsPrice">0.00</span> <!--DISPLAY HERE THE TOTAL PRICE ORDERED BY THE CUSTOMER-->
                        <button class="btn btn-primary mb-3 btn-lg checkoutButton" disabled="true" data-bs-toggle="modal" data-bs-target="#checkoutModal">
                            Checkout
                            <span class="h5 pt-1 totalItems"></span><!--DISPLAY HERE THE TOTAL ITEMS ORDERED-->
                        </button>   
                    </div>
                </div>
            </div>

        </div>
    </section>
<!--CHECKOUT MODAL-->
<div class="modal modal-xl modal-dialog-scrollable fade" id="checkoutModal" tabindex="-2" aria-labelledby="checkoutItemModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 fw-bold" id="checkoutItemModal">Checkout
          </h1>
          <button type="button" class="btn-close close--checkout" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="">
            <div class="container-fluid mb-5">
                <div class="container-fluid bg-body-tertiary py-3 rounded-3">
                    <div class="container-sm ms-0 p-3 text-bg-light border border-3 border-gray rounded-2">
                        <i class="bi bi-geo-alt-fill fs-4 text-danger"></i>
                        <span class="h6 mx-1">Delivery Address</span>

                        <div class="h6 mx-4 px-2 fw-bold mt-2"><?php echo $firstname . ' ' . $lastname ?>
                            <span class="h6">|</span>
                            <span class="h6"><?php echo $phone_no?></span>
                        </div>
                        <div class="h6 mt-3 mx-4 px-2"><?php echo $address?></div>
                    </div>

                    <br>
                    <div class="updateContainer">
                                                    
                    </div>

                    

                    <div class="container-sm ms-0 p-2 text-bg-light border border-3 border-gray rounded-2 d-flex">
                        <div class="h6 mt-2 w-50 mx-1 px-1">Order Total
                            <span class="h6 checkout--overall--items">(1 items) :</span> <!--TOTAL ITEMS ORDERED-->
                        </div>
                        <div class="container d-flex justify-content-end mt-2">
                            <div class="h6 fw-bold">Php</div>
                            <div class="h6 fw-bold px-1 checkout--overall--price">
                                <span class="h6">300.00</span>
                            </div> <!--TOTAL PRICE NG LAHAT NG ORDER-->
                        </div>
                    </div>

                    <br> 

                    <div class="container-sm ms-0 p-2 text-bg-light border border-3 border-gray rounded-2 d-flex">
                        <div class="d-flex w-25 mt-2">
                            <i class="bi bi-currency-dollar fw-bold fs-4 text-danger"></i>
                            <div class="h6 px-1 mt-2">Payment Method</div>
                        </div>
                        <div class="container d-flex justify-content-end mt-2">
                            <select class="form-select text-bg-light border border-2 border-dark-subtle h6 w-25 delivery--select" aria-label="Default select example">
                                <option value="cod">Cash on Delivery</option> <!--DAPAT ITO MASAVE DIN SA DATABASE-->
                                <option value="epay" disabled>GCash (unavailable)</option>
                            </select>
                        </div>
                    </div>

                    <br>
                    
                    <div class="container-sm ms-0 p-2 text-bg-light border border-3 border-gray rounded-2">
                        <div class="h6 mt-2 w-50 mx-1 px-0">
                            <i class="bi bi-calendar fs-5 text-primary"></i>
                            <span class="h6 px-1">Payment Details</span>
                        </div>
                        <div class="container d-flex mt-5">
                            <div class=" w-25 mx-0">
                                <div class="h6 mx-2 pt-2 ms-auto">Order Total</div>
                            </div>

                            <div class=" w-25 d-flex mt-1 justify-content-end ms-auto">
                                <div class="h6 mx-2 pt-1 ms-auto">Php
                                    <span class="h6 checkout--overall--price">300.00</span> <!--TOTAL PRICE NG LAHAT NG SELECTED ITEMS-->
                                </div>
                            </div>

                        </div>

                        <div class="container d-flex">
                            <div class=" w-25 mx-0">
                                <div class="h6 mx-2 pt-2 ms-auto fw-bold">Total Payment</div>
                            </div>

                            <div class=" w-25 d-flex mt-1 justify-content-end ms-auto">
                                <div class="h6 mx-2 pt-1 ms-auto fw-bold text-danger">Php
                                    <span class="h6 fw-bold text-danger checkout--overall--price">300.00</span> <!--TOTAL PRICE NG LAHAT NG SELECTED ITEMS-->
                                </div>
                            </div>

                        </div>
                    </div>

                <hr class="w-100 mx-0 border border-black border-1 mt-4">


                    <div class="container d-flex justify-content-end px-0 mt-5">
                        <div class="mx-3">
                            <div class="h6 mt-2">Total Payment</div>
                            <div class="h6 text-danger fw-bold">Php
                                <span class="h6 text-danger fw-bold checkout--overall--price">300.00</span> <!--TOTAL PRICE NG LAHAT NG SELECTED ITEMS-->
                            </div>
                        </div>
                        <div class="px-1 px-lg-2 px-xl-2 justify-content-end">
                            <a href="order_status.php" class="btn btn-primary rounded-1 fw-bold h6 h-100 place--order" id="placeOrderButton">
                               <span class="h6 place--order--text">Place Order</span> 
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal-footer">

          <button type="button" class="btn btn-secondary close--checkout" data-bs-dismiss="modal">Close</button>
          
        </div>
      </div>
    </div>
</div>

<!--REMOVE MODAL-->
<div class="modal fade" id="removeModal" tabindex="-1" aria-labelledby="removeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 fw-bold" id="removeModalLabel">Remove items</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="removeModalBody">
          Remove 
            <span class="h6 cart--items">
                
            </span> 
          items from your cart?
        </div>
        <div class="modal-footer">

          <button type="button" class="text-light text-decoration-none btn btn-danger" data-bs-toggle="modal" data-bs-target="#removeModalSuccess" id="confirmRemoveButton">Yes</a>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
          
        </div>
      </div>
    </div>
</div>
<!--END OF REMOVE MODAL-->

<!--REMOVE MODAL-->
<div class="modal fade" id="removeModalSuccess" tabindex="-1" aria-labelledby="removeModalLabelSuccess" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 fw-bold" id="removeModalLabelSuccess">Remove successful</h1>
          <button type="button" class="btn-close close--icon" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-success">
          <p class="h6">
            <span class="bi bi-check-circle-fill"></span>
            <span class="item--cart"></span>
            items was successfully removed from your cart!
          </p>
        </div>
        <div class="modal-footer">

          <button type="button" class="btn btn-secondary close--button" data-bs-dismiss="modal">Close</button>
          
        </div>
      </div>
    </div>
</div>
<!--END OF REMOVE MODAL-->

    <!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">Confirm logout</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to logout?
        </div>
        <div class="modal-footer">

          <a href="logout.php" class="text-light text-decoration-none btn btn-primary">Yes</a>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          
        </div>
      </div>
    </div>
</div>

        
        
        
        
    <script src="cart.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>