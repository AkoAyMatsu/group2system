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
    <link rel="stylesheet" href="order_status.css">
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
        </div>


        <div class="container-fluid mb-5">
            <ul class="nav nav-tabs row-cols-5">
                <li class="nav-item">
                    <a class="nav-link active text-bg-primary" data-bs-toggle="tab" href="#toPay">To Pay</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-bg-primary" data-bs-toggle="tab" href="#toShip">To Ship</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-bg-primary" data-bs-toggle="tab" href="#toReceive">To Receive</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-bg-primary" data-bs-toggle="tab" href="#Completed">Completed</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-bg-primary" data-bs-toggle="tab" href="#Cancelled">Cancelled</a>
                </li>
                <!-- Add tabs for other categories as needed -->
            </ul>


            <div class="tab-content">
                <!--TO PAY TAB PANE-->
                <div id="toPay" class="tab-pane active">

                <div class="container-fluid border border-1 bg-primary-light-subtle rounded-bottom-1 border-gray p-4">
                    <div class="checkoutItemsContainer" id="checkoutItemsContainer" class="border-2 border-black">
                        <!--<div id="checkoutItemsContainer" class="container-sm w-70 ms-5 p-2 text-bg-light border border-2 border-black rounded-1 rounded-bottom-0 d-flex mt-5 h-50">
                            <img src="rounded-gallon.jpeg" alt="" width="160" height="175" class="rounded-2 border border-1 border-black my-3 mx-3">
                            <div class="h6 fw-bold p-3 mt-3 py-1 h-25 w-100 text-end">
                                Pending
                                <div class="h6 text-start mt-3 fw-bold">18L Rounded Gallon Water</div>
                                <div class="h6 mt-2 d-flex">Order Type: 
                                    <span class="h6 px-1 fw-bold">Refill</span>
                                </div>
                                <div class="h6 mt-4 py-1">
                                    x <span class="h6">10</span>
                                </div>
                                <div class="h6 mt-0 py-0 text-danger">
                                    Php <span class="h6 text-danger">300.00</span>
                                </div>
                            </div>
                        </div>-->
                    </div>

                    
                    <div class="itemsAndPriceContainer" id="itemsAndPriceContainer">
                        <!--<div class="container-sm w-70 ms-5 p-2 text-bg-light border border-2 border-black rounded-0 rounded-bottom-1 d-flex mt-0 h-50">
                            <div class="h6 mt-2 w-50 mx-3 px-0">1
                                <span class="h6">item/s</span>
                            </div>
                            <div class="container d-flex justify-content-end mt-2">
                                <div class="h6">Order Total: 
                                    <span class="h6 text-danger">Php</span>
                                </div>
                                <div class="h6 text-danger px-1">300.00</div>
                            </div> 
                        </div>-->
                    </div>
                    
                    <div class="dateContainer" id="dateContainer">
                        <!--<div class="container-sm w-70 ms-5 p-2 d-flex mt-3 h-50 border-bottom border-3 justify-content-between">
                            <div class="h6 mt-2 w-50 mx-3 px-0 text-primary">Waiting for order confirmation
                            </div>
                            <div class="mt-2">
                                05/20/2023
                            </div> 
                        </div>-->
                    </div>

                    <div class="noOrderContainer" id="noOrderContainer">

                    </div>
                    


                    <div class="container-fluid w-70 ms-0 p-0 d-flex mt-3 h-50">
                        <button class="btn btn-md btn-danger text-light text-start order--cancellation" id="order--cancellation">Cancel Order</button>
                    </div>

                </div>
                    
                </div>
                <!--END OF TO PAY TAB PANE-->
                

                <!--TO SHIP TAB-->
                <div id="toShip" class="tab-pane">
                    <div class="container-sm w-70 ms-5 p-2 text-bg-light border border-2 border-black rounded-1 rounded-bottom-0 d-flex mt-5 h-50">
                        <img src="slim-gallon.jpg" alt="" width="160" height="175" class="rounded-2 border border-1 border-black my-3 mx-3">
                        <div class="h6 fw-bold p-3 mt-3 py-1 h-25 w-100 text-end">
                            In transit
                            <div class="h6 text-start mt-3 fw-bold">18L Rounded Gallon Water</div>
                            <div class="h6 mt-2 d-flex">Order Type: 
                                <span class="h6 px-1 fw-bold">Refill</span>
                            </div>
                            <div class="h6 mt-4 py-1">
                                x <span class="h6">10</span>
                            </div>
                            <div class="h6 mt-0 py-0 text-danger">
                                Php <span class="h6 text-danger">300.00</span>
                            </div>
                        </div>
                    </div>

                    <div class="container-sm w-70 ms-5 p-2 text-bg-light border border-2 border-black rounded-0 rounded-bottom-1 d-flex mt-0 h-50">
                        <div class="h6 mt-2 w-50 mx-3 px-0">1
                            <span class="h6">item/s</span>
                        </div>
                        <div class="container d-flex justify-content-end mt-2">
                            <div class="h6">Order Total: 
                                <span class="h6 text-danger">Php</span>
                            </div>
                            <div class="h6 text-danger px-1">300.00</div>
                        </div> 
                    </div>

                    <div class="container-sm w-70 ms-5 p-2 d-flex mt-3 h-50 border-bottom border-3 justify-content-between">
                        <div class="h6 mt-2 w-50 mx-2 px-0 text-primary d-flex">
                            <div class="bi bi-truck fs-3"></div>
                            <div class="h6 px-2 mt-2">Item in transit</div>
                        </div>
                        <div class="py-1 mt-3">
                            05/20/2023
                        </div> 
                    </div>


                    <div class="container-sm w-70 ms-5 p-2 mt-3 d-flex h-50 justify-content-between">
                        <div>
                            <div class="h6">Receive products and</div>
                            <div class="h6">make payment by 
                                <span class="h6 fw-bold">
                                    05/20/2023
                                </span>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-primary text-light h-100" disabled="true">Order Received</button>
                        </div>
                    </div>
                </div>
                <!--END OF TO SHIP TAB PANE-->


                <!--TO RECEIVE TAB PANE-->
                <div id="toReceive" class="tab-pane">
                    <div class="container-sm w-70 ms-5 p-2 text-bg-light border border-2 border-black rounded-1 rounded-bottom-0 d-flex mt-5 h-50">
                        <img src="slim-gallon.jpg" alt="" width="160" height="175" class="rounded-2 border border-1 border-black my-3 mx-3">
                        <div class="h6 fw-bold p-3 mt-3 py-1 h-25 w-100 text-end">
                            To receive
                            <div class="h6 text-start mt-3 fw-bold">18L Rounded Gallon Water</div>
                            <div class="h6 mt-2 d-flex">Order Type: 
                                <span class="h6 px-1 fw-bold">Refill</span>
                            </div>
                            <div class="h6 mt-4 py-1">
                                x <span class="h6">10</span>
                            </div>
                            <div class="h6 mt-0 py-0 text-danger">
                                Php <span class="h6 text-danger">300.00</span>
                            </div>
                        </div>
                    </div>

                    <div class="container-sm w-70 ms-5 p-2 text-bg-light border border-2 border-black rounded-0 rounded-bottom-1 d-flex mt-0 h-50">
                        <div class="h6 mt-2 w-50 mx-3 px-0">1
                            <span class="h6">item/s</span>
                        </div>
                        <div class="container d-flex justify-content-end mt-2">
                            <div class="h6">Order Total: 
                                <span class="h6 text-danger">Php</span>
                            </div>
                            <div class="h6 text-danger px-1">300.00</div>
                        </div> 
                    </div>

                    <div class="container-sm w-70 ms-5 p-2 d-flex mt-3 h-50 border-bottom border-3 justify-content-between">
                        <div class="h6 mt-2 w-50 mx-2 px-0 text-primary d-flex">
                            <div class="bi bi-truck fs-3"></div>
                            <div class="h6 px-2 mt-2">Item to receive</div>
                        </div>
                        <div class="py-1 mt-3">
                            05/20/2023
                        </div> 
                    </div>


                    <div class="container-sm w-70 ms-5 p-2 mt-3 d-flex h-50 justify-content-between">
                        <div>
                            <div class="h6">Receive products and</div>
                            <div class="h6">make payment by 
                                <span class="h6 fw-bold">
                                    05/20/2023
                                </span>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-primary text-light h-100">Order Received</button>
                        </div>
                    </div>
                </div>
                <!--END OF TO RECEIVE TAB PANE-->


                <!--COMPLETED PANE-->
                <div id="Completed" class="tab-pane">
                    <div class="container-sm w-70 ms-5 p-2 text-bg-light border border-2 border-black rounded-1 rounded-bottom-0 d-flex mt-5 h-50">
                        <img src="slim-gallon.jpg" alt="" width="160" height="175" class="rounded-2 border border-1 border-black my-3 mx-3">
                        <div class="h6 fw-bold p-3 mt-3 py-1 h-25 w-100 text-end">
                            Completed
                            <div class="h6 text-start mt-3 fw-bold">18L Rounded Gallon Water</div>
                            <div class="h6 mt-2 d-flex">Order Type: 
                                <span class="h6 px-1 fw-bold">Refill</span>
                            </div>
                            <div class="h6 mt-4 py-1">
                                x <span class="h6">10</span>
                            </div>
                            <div class="h6 mt-0 py-0 text-danger">
                                Php <span class="h6 text-danger">300.00</span>
                            </div>
                        </div>
                    </div>

                    <div class="container-sm w-70 ms-5 p-2 text-bg-light border border-2 border-black rounded-0 rounded-bottom-1 d-flex mt-0 h-50">
                        <div class="h6 mt-2 w-50 mx-3 px-0">1
                            <span class="h6">item/s</span>
                        </div>
                        <div class="container d-flex justify-content-end mt-2">
                            <div class="h6">Order Total: 
                                <span class="h6 text-danger">Php</span>
                            </div>
                            <div class="h6 text-danger px-1">300.00</div>
                        </div> 
                    </div>

                    <div class="container-sm w-70 ms-5 p-2 d-flex mt-3 h-50 border-bottom border-3 justify-content-between">
                        <div class="h6 mt-2 w-50 mx-2 px-0 text-primary d-flex">
                            <div class="bi bi-truck fs-3"></div>
                            <div class="h6 px-2 mt-2">Order Completed</div>
                        </div>
                        <div class="py-1 mt-3">
                            05/20/2023
                        </div> 
                    </div>
                </div>
                <!--END OF COMPLETED PANE-->


                <!--CANCELLED TAB PANE-->
                <div id="Cancelled" class="tab-pane">
                    <div class="cancelledItemsContainer" id="cancelledItemsContainer">
                        <!--<div class="container-sm w-70 ms-5 p-2 text-bg-light border border-2 border-black rounded-1 rounded-bottom-0 d-flex mt-5 h-50">
                            <img src="slim-gallon.jpg" alt="" width="160" height="175" class="rounded-2 border border-1 border-black my-3 mx-3">
                            <div class="h6 fw-bold p-3 mt-3 py-1 h-25 w-100 text-end">
                                Cancelled
                                <div class="h6 text-start mt-3 fw-bold">18L Rounded Gallon Water</div>
                                <div class="h6 mt-2 d-flex">Order Type: 
                                    <span class="h6 px-1 fw-bold">Refill</span>
                                </div>
                                <div class="h6 mt-4 py-1">
                                    x <span class="h6">10</span>
                                </div>
                                <div class="h6 mt-0 py-0 text-danger">
                                    Php <span class="h6 text-danger">300.00</span>
                                </div>
                            </div>
                        </div>-->
                    </div>
                    
                    <div class="itemsCancelled" id="itemsCancelled">
                        <!--<div class="container-sm w-70 ms-0 p-2 text-bg-light border border-2 border-black rounded-1 d-flex h-50">
                            <div class="h6 mt-2 w-50 mx-3 px-0">1
                                <span class="h6">item/s</span>
                            </div>
                            <div class="container d-flex justify-content-end mt-2">
                                <div class="h6">Order Total: 
                                    <span class="h6 text-danger">Php</span>
                                </div>
                                <div class="h6 text-danger px-1">300.00</div>
                            </div>  
                        </div>-->
                    </div>

                    <div class="dateCancelled" id="dateCancelled">
                        <!--<div class="container-sm w-70 ms-5 p-2 d-flex mt-3 h-50 border-bottom border-3 justify-content-between">
                            <div class="h6 mt-2 w-50 mx-2 px-0 text-primary d-flex">
                                <div class="bi bi-truck fs-3"></div>
                                <div class="h6 px-2 mt-2">Order Cancelled</div>
                            </div>
                            <div class="py-1 mt-3">
                                05/20/2023
                            </div> 
                        </div>-->                     
                    </div> 

                </div>
                    
                    

                <!--END OF CANCELLED TAB PANE-->

                
            </div>
        </div>
</section>

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


        
        
        
        
    <script src="order_status.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>