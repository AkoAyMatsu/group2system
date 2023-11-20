<?php
    require "handleDash.php";
    require "handleShop.php";
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
    <link rel="stylesheet" href="customer_shop_products.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <nav class="navbar bg-primary">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon fs-5"></span>
            </button>
            <a class="navbar-brand text-light fs-5 me-auto fw-semibold d-sm-flex company--name" href="#">BANI WATER REFILLING STATION</a>
            <!--Dropdown for user logout-->
                <div class="dropdown user--dropdown d-md-flex d-sm-none d-none">
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
                            <a class="dropdown-item" href="customer_profile.html">Profile
                                <span class="bi bi-person-circle fs-3 px-1 dp-icons"></span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="customerCart.php">My Cart
                                <span class="bi bi-cart fs-3 px-1 dp-icons"></span>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li class="">
                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout
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
                            echo " ". $username . "!";         
                        ?>
                    </h5>
                    <button type="button" class="btn-close close--btn" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <div class="offcanvas-header canvas--header--2">
                    <div class="d-inline-flex align-items-center py-2 justify-content-center rounded-circle bg-primary --user">
                        <img src="<?php echo $user_image;?>" alt="User Images" class="rounded-circle" width="120px" height="112px">
                    </div>
                    <div class="h5 text-light me-auto px-3 mt-5">
                        <?php 
                            echo $username; 
                        ?>
                        <div class="h5 text-light pt-2">USER ID: 
                            <span class="id--number h5 text-light">
                                <?php echo $userid?>
                            </span>
                        </div>
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
                            <a class="nav-link active fs-5 text-light" href="customerCart.php">
                                <span class="bi bi-cart fs-3 px-2"></span>Cart
                            </a>
                        </li>
                        <!--Profile-->
                        <li class="nav-item">
                            <a class="nav-link active fs-5 text-light" href="customer_profile.html">
                                <span class="bi bi-person-circle fs-3 px-2"></span>Profile
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="offcanvas-header canvas--footer">
                    <ul class="navbar-nav justify-content-end pe-3 logout--nav">
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
    
<!--PRODUCT SECTION-->
<section>
        <div class="container-fluid p-5 mt-1">
        <?php foreach($products as $product): 
            $product_name = $product['product_type'];
            $productid = $product['product_id'];
            $result = strtolower(str_replace(' ', '', substr($product_name, strpos($product_name, ' ') + 1)));
            $productIdClass = 'class_' . $result;
            $container_class = 'container_' . $result; // Generate a unique class name for each product
            $priceLabel = 'priceLabel_' . $result; //unique classes para doon sa price label
            $selectOrder = 'selectOrder_' . $result; //unique classes for each selection of order
            $add_cart = 'addCart_' . $result; //unique classes para doon sa order class sa main section
            $order_now = 'orderNow_' . $result; //unique classes para doon sa pag click ng order sa main section
            $product_modal = 'modal_' . $result; //uniques classes ng target para dooon sa round and slim modal
            $minQuantity = 'sub_' . $result; //subtraction class for quantity
            $addQuantity = 'add_' . $result; //addition class for quantity
            $orderQuantity = 'quant_' . $result; //quantity ng product na gusto ni user
            $totalPrice = 'totalprice_' . $result; //total price doon sa modal
            $cart_add = 'addtocart_' . $result; //final add to cart ng user doon sa may modal
            $now_order = 'noworder_' . $result; //final order ng user doon sa may modal 
            $order_type_label = 'type_' . $result; //order type label ng modal (ORDER (Buy))  
            $close_button = 'close_' . $result; //close button ng

            //second modal
            $addToCartModal = "atc_" . $result;
            $closeCart = 'cc_' . $result;
            $cartItems = "cartItems_" . $result;
            $noCart = 'nc_' . $result;
            $confirmCart = 'confcart_' . $result;

            $orderNowModal = "on_" . $result;
            $closeOrder = 'co_' . $result;
            $orderItems = "orderItems_" . $result;
            $noOrder = "no_" . $result;
            $confirmOrder = 'conforder_'.$result;
            //end modal

            //third modal
            $successCartModal = 'scm_' . $result;
            $closeSuccessCart = 'csc_' . $result;
            $successCart = 'sc_' . $result;

            $successOrderModal = 'som_' . $result;
            $closeSuccessOrder = 'cso_' . $result;
            $successOrder = 'so_' . $result;
            //end of third modal


        ?>  
            <div class="container-fluid bg-primary-subtle w-100 h-100 d-md-inline-flex d-sm-block  border-3 rounded-3 text-sm-center text-center rg--container">
                
                <div class="p-2 img--container">
                    <img src="<?php echo '../'. $product['product_img']?>" alt="" class="p-2 img-fluid rd--gallon"> <!--Image ng product-->
                </div>
                    <div class="rd--container mb-0 mb-sm-1 py-0 py-md-3">
                        <div class="h5 mx-sm-3 ms-md-0"><?php echo $product_name ?>
                            <span class="h5 d-none <?php echo $productIdClass?>"><?php echo $productid?></span>
                        </div> <!--pangalan ng product-->
                        <div class="h5 mx-sm-3 ms-md-auto d-md-flex justify-content-md-start">
                            Php<span class="h5 px-1 <?php echo $priceLabel ?>">280.00</span> <!--price label ng product-->
                        </div>
                        
                        <div class="py-1 mx-sm-3 ms-md-auto d-sm-flex justify-content-sm-center d-md-flex justify-content-md-start d-flex justify-content-center select--option">
                            <select class="form-select text-bg-primary fs-5 w-50 <?php echo $selectOrder?>" aria-label="Default select example"><!--Selection ng orders-->
                                <option value="Buy">Buy</option>
                                <option value="Refill">Refill</option>
                                <option value="Borrow">Borrow</option>
                            </select>
                        </div>
    
    
                        <div class="d-flex py-4 py-sm-4 py-md-0 mt-md-5 mx-sm-3 mx-md-0 justify-content-sm-center justify-content-center order--buttons">
                            <button type="button" class="btn btn-primary ms-sm-3 ms-1 ms-md-0 <?php echo $add_cart?>" data-bs-toggle="modal" data-bs-target="#<?php echo $product_modal?>">
                                <div class="bi bi-cart-plus fs-3"></div>Add to Cart <!--add to cart ng main section-->
                            </button>
                            <button type="button" class="btn btn-primary ms-sm-3 me-sm-3 ms-2 me-2 me-md-auto <?php echo $order_now?>" data-bs-toggle="modal" data-bs-target="#<?php echo $product_modal?>">
                                <div class="bi bi-coin fs-3"></div>Order Now <!--order now button ng main section-->
                            </button>
                        </div>
                    </div>   
            </div>
<!-- MODAL SECTION -->
    <div class="modal fade" id="<?php echo $product_modal?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title fs-4" id="exampleModalLabel">ORDER
                        <span class="fs-4 <?php echo $order_type_label?>"></span> <!--label kung anong type ng order buy, refill, or borrow-->
                    </div>
                    <button type="button" class="btn-close ms-auto fs-4 <?php echo $close_button?>" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            <div class="modal-body d-flex bg-light-subtle">
                <div class="container-fluid text-center">
                    <img src="<?php echo '../'. $product['product_img']?>" alt="" class="p-2 w-50 rounded-4 border-3"> <!--image ng product doon sa modal-->
                    <div class="h5 <?php echo $product_name?>"></div>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-secondary mx-1 <?php echo $minQuantity?>"> <!--minus button para doon sa quantity ng product -->
                            <div class="bi bi-dash fs-4 mt-1"></div>
                        </button>
                        <div class="text-bg-primary rounded-2 fs-3 py-1 w-25 <?php echo $orderQuantity?>"></div> <!--container for displaying the quantity of the product-->
                        <button class="btn btn-secondary mx-1 <?php echo $addQuantity?>"> <!--add button para doon sa quantity ng product -->
                            <div class="bi bi-plus fs-4"></div>
                        </button>
                    </div>
                    <div class="fs-5 py-3 ms-2">
                        Total Price
                    </div>
                    <div class="fw-bold ms-3">
                        <div class="fs-5">
                            Php<span class="fs-5 px-1 <?php echo $totalPrice?>">0.00</span> <!--label para doon sa total price sa loob ng modal-->
                        </div>
                        
                    </div>
                </div>
            </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary <?php echo $cart_add?>" data-bs-toggle="modal" data-bs-target="#<?php echo $addToCartModal?>">Add to Cart</button>
                        <button type="button" class="btn btn-primary ms-auto fs4 <?php echo $now_order?>" data-bs-toggle="modal" data-bs-target="#<?php echo $orderNowModal?>">Order Now</button>
                    </div>
                </div>
            </div>
        </div>
<!--END OF MODAL SECTION-->
        <!-- ========== Add to Cart Modal ========== -->
    <div class="modal" tabindex="-1" id="<?php echo $addToCartModal?>">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title fw-bold">Confirm Order</h5>
              <button type="button" class="btn-close <?php echo $closeCart?>" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>Add
                <span class="<?php echo $cartItems?>"></span>
                <span>items to cart?</span>
              </p>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger <?php echo $noCart?>" data-bs-dismiss="modal">No</button>
              <button type="submit" class="btn btn-primary <?php echo $confirmCart?>" data-bs-toggle="modal" data-bs-target="#<?php echo $successCartModal?>">Yes</button>
                <!--FINAL SUBMISSION NG LAHAT NG INFO NA DAPAT ISTORE SA DATABASE LIKE QUANTITY, TYPE OF PRODUCT, ORDER TYPE
                    TOTAL PRICE, ORDER_ID (UNIQUENESS), ETC..-->
            </div>
          </div>
        </div>
      </div>
      <!-- ========== End Section ========== -->

      <!-- ========== Order Now Modal  ========== -->
      <div class="modal" tabindex="-1" id="<?php echo $orderNowModal?>">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title fw-bold">Confirm Order</h5>
              <button type="button" class="btn-close <?php echo $closeOrder?>" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>Order
                <span class="<?php echo $orderItems?>"></span>
                <span>items now?</span>
              </p>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger <?php echo $noOrder?>" data-bs-dismiss="modal">No</button>
                <button type="submit" class="btn btn-primary <?php echo $confirmOrder?>" data-bs-toggle="modal" data-bs-target="#<?php echo $successOrderModal?>">Yes</button>

              
                <!--FINAL SUBMISSION NG LAHAT NG INFO NA DAPAT ISTORE SA DATABASE LIKE QUANTITY, TYPE OF PRODUCT, ORDER TYPE
                    TOTAL PRICE, ORDER_ID (UNIQUENESS), ETC..-->
            </div>
          </div>
        </div>
      </div>
      <!-- ========== End Section ========== -->

      <!-- ========== Success Add to Cart ========== -->
    <div class="modal" tabindex="-1" id="<?php echo $successCartModal?>">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title fw-bold">Success!</h5>
              <button type="button" class="btn-close <?php echo $closeSuccessCart?>" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="bi bi-check-circle text-success">
                    <span class="h6 <?php echo $successCart?> text-decoration-none"></span>
                    <span class="h6 text-decoration-none">items successfully added to cart!</span>
                </div>
            </div>
            <div class="modal-footer">
                <a href="customerCart.php" class="btn btn-primary goToCart">Go to Cart</a>
            </div>
          </div>
        </div>
      </div>

      
    <!-- ========== End Section ========== -->
    
    <!-- ========== Success Order Now ========== -->
    <div class="modal" tabindex="-1" id="<?php echo $successOrderModal?>">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title fw-bold">Success!</h5>
              <button type="button" class="btn-close <?php echo $closeSuccessOrder?>" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="bi bi-check-circle text-success">
                    <span class="h6 <?php echo $successOrder?> text-decoration-none"></span>
                    <span class="h6 text-decoration-none">items successfully ordered!</span>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary checkout">Go to Checkout</a>
            </div>
          </div>
        </div>
      </div>
    <!-- ========== End Section ========== -->
    
    
        <div class="py-4"></div>
    <?php endforeach; ?>
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
    

      

    

    <!---->
    
        
    <script src="shopProduct.js">
    </script>
    
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>










