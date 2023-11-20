<?php 


    require "handleDash.php";
    require "handleShop.php";
    //include 'submit_order.php';
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
    <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="customer_cart.css">
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
                        <span class="px-2 fs-5 user--name"><?php echo $username?></span>
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
                            <a class="dropdown-item" data-bs-target="#logoutModal" data-bs-toggle="modal">Logout
                                <span class="bi bi-box-arrow-left fs-3 px-2 dp--icons"></span>
                            </a>
                        </li>
                    </ul>
                </div>
            <!--end of that dropdown-->

            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header canvas--header">
                    <h5 class="offcanvas-title text-dark" id="offcanvasNavbarLabel">Welcome <?php echo $username?>!</h5>
                    <button type="button" class="btn-close close--btn" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <div class="offcanvas-header canvas--header--2">
                    <div class="d-inline-flex align-items-center py-2 justify-content-center rounded-circle bg-primary --user">
                        <img src="<?php echo $user_image;?>" alt="User Images" class="rounded-circle" width="120px" height="112px">
                    </div>
                    <div class="h5 text-light me-auto px-3 mt-5"><?php echo $username?>
                        <div class="h5 text-light pt-2">USER ID: <span class="id--number h5 text-light"><?php echo $userid?></span></div>
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

    <section>
        <div class="container-fluid pt-5 h-100 w-100 mt-1 table--container" id="orderHistory">
            <ul class="nav nav-tabs dash--tabs">
                <li class="nav-item title--place d-flex">
                    <div class="nav-link fs-5 text-bg-dark dash--title" aria-current="page"><a href="customerCart.php">Cart Items</a></div>
                    <div class="nav-link fs-5 text-bg-dark dash--title" aria-current="page"><a href="customer_order_checkout.html">Order</a></div>
                    <div class="nav-link fs-5 text-bg-dark dash--title" aria-current="page"><a href="customer_order_status.html">Order Status</a></div>
                </li>
            </ul>
            <table class="table table-responsive table-bordered table-light fs-5 dash--table">
                <tbody>
                    <?php include "displayCartItems.php"?>
                </tbody>
            </table>
            <div class="container-fluid">
                <div class="container-fluid d-flex">
                    <input class="form-check-input mb-2 mb-sm-2 fs-1 border-5 border-gray box--size" type="checkbox" value="" id="flexCheckDefault">
                    <div class="h5 mt-3 mt-sm-3 mt-md-3 all--text">All</div>
                    <button class="btn btn-danger ms-auto d-md-inline-flex h-25 mt-3 fs-5 mt-lg-3" data-bs-toggle="modal" data-bs-target="#removeModal">
                        <span class="h6 d-sm-none d-md-inline mt-md-1 px-md-1">Remove</span>
                        <span class="bi bi-trash"></span>
                    </button> 
                    <div class="mt-3 py-1 h6 ms-auto">
                        Total
                        <span class="h6 fw-bold px-0">Php</span>
                        <span class="h6 fw-bold pe-4">1000.00</span>
                        <button class="btn btn-primary mb-2">
                            Checkout
                            <span class="h6 pt-1">(1)</span>
                        </button>   
                    </div>
                </div>
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

    <!-- Remove Modal -->
    <div class="modal fade" id="removeModal" tabindex="-1" aria-labelledby="logoutModal" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5 fw-bold" id="logoutModalLabel">Remove items?</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Remove <span class="h6 cart--items">10</span>
              <span class="h6">items from your cart?</span>
            </div>
            <div class="modal-footer">
    
              <button class="text-light text-decoration-none btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmedRemoval">Yes</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
              
            </div>
          </div>
        </div>
      </div>

      <!--Confirmed remove modal-->

      <div class="modal fade" id="confirmedRemoval" tabindex="-1" aria-labelledby="logoutModal" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5 fw-bold" id="confirmedRemovalLabel">Sucess</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <span class=""></span>
              Successfully removed <span class="h6 cart--items">10</span>
              <span class="h6">items from your cart</span>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

        
        
        
        
        
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>