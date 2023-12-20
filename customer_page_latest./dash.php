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
    <link rel="stylesheet" href="customer_dashboard.css">
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
                                <span class="bi bi-person-circle fs-3 px-1"></span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="cart.php">My Cart
                                <span class="bi bi-cart fs-3 px-1"></span>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li class="">
                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutModal" href="logout.php">Logout
                                <span class="bi bi-box-arrow-left fs-3 px-2"></span>
                            </a>
                        </li>
                    </ul>
                </div>

            <!--end of that dropdown-->

            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header canvas--header">
                    <h5 class="offcanvas-title text-dark" id="offcanvasNavbarLabel">Welcome 
                        <span class="h5 --userWelcome">
                            <?php
                                echo $username . "!";
                            ?>
                        </span></h5>
                    <button type="button" class="btn-close close--btn" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <div class="offcanvas-header canvas--header--2">
                    <div class="d-inline-flex align-items-center py-2 justify-content-center rounded-circle bg-primary --user">
                        <img src="<?php echo $user_image;?>" alt="User Images" class="rounded-circle" width="120px" height="112px">
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
<div class="container-fluid bg-primary-subtle">
    <div class="container-xl p-4 d-flex">
        <!--Profile Card-->
            <div class="card ms-auto profile--card" id="profileLink">
                <div class="bi bi-person-circle py-2 card--icon"></div>
                <div class="card-body">
                    <h5 class="card-title fw-bold">PROFILE</h5>
                    <a href="#profile" class="btn btn-primary">
                        <span class="h5">Go to</span>
                        <span class="bi bi-arrow-down-square fs-4 px-1 goto--icon"></span>
                    </a>
                </div>
            </div>
            <!--End-->

            <!--Order History Card-->
            <div class="card me-auto order--card" id="orderLink">
                <div class="bi bi-clipboard2-check py-2 card--icon"></div>
                <div class="card-body">
                    <h5 class="card-title fw-bold">ORDER HISTORY</h5>
                    <a href="#orderHistory" class="btn btn-primary">
                        <span class="h5">Go to</span>
                        <span class="bi bi-arrow-down-square fs-4 px-1 goto--icon"></span>
                    </a>
                </div>
            </div>
        <!--End-->
    </div>
    
</div>
<!--PROFILE SECTION-->
<div data-bs-spy="scroll" data-bs-target="#profileLink" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollpsy-example" tabindex="1">
    <div class="container-fluid pt-5 h-100 w-100 mt-2 table--container" id="profile">
        <ul class="nav nav-tabs dash--tab">
            <li class="nav-item title--place">
                <div class="nav-link fs-3 text-bg-dark dash--title" aria-current="page">PROFILE</div>
            </li>
        </ul>
        <div class="container-fluid fs-1 bg-secondary py-5 userImageContainer">
            <div class="container-fluid p-3 text-center">
                <div class="p-5 d-inline-flex justify-content-center rounded-circle text-bg-dark userImage">
                   <img src="<?php echo $user_image;?>" alt="User Images" class="rounded-circle" width="210px" height="210px">
                </div>
                <h1 class="text-light px-2 py-4 profile--name">
                    <?php
                        echo $username;
                    ?>
                </h1>
            </div>
            
            <div class="mb-3">
                <div class="row">
                    <div class="col">
                      <label for="FirstName" class="form-label fs-4 text-light px-1">First Name</label>
                      <input type="text" class="form-control py-3 fs-4 first--name" id="FirstName" placeholder="First Name" disabled="true"
                            value="<?php echo $firstname;?>"
                      >
                      
                    </div>
                    <div class="col">
                      <label for="LastName" class="form-label fs-4 text-light px-1">Last Name</label>
                      <input type="text" class="form-control py-3 fs-4 last--name" id="LastName" placeholder="Last Name" disabled="true"
                        value="<?php echo $lastname;?>"
                      >
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                      <label for="Address" class="form-label fs-4 text-light px-1">Address</label>
                      <input type="text" class="form-control py-3 fs-4 user--address" id="Address" placeholder="Address" disabled="true"
                      
                        value="<?php echo $address;?>"

                      >
                    </div>
                    <div class="col">
                      <label for="ContactNumber" class="form-label fs-4 text-light px-1">Contact Number</label>
                      <input type="text" class="form-control py-3 fs-4 user--contact" id="ContactNumber" placeholder="Contact Number" disabled="true"
                        value="<?php echo $phone_no;?>"
                      >
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                      <label for="UserType" class="form-label fs-4 text-light px-1">User Type</label>
                      <input type="text" class="form-control py-3 fs-4 user--type" id="UserType" placeholder="User Type" disabled="true"
                        value="<?php echo $user_role;?>"
                      >
                    </div>
                    <div class="col">
                      <label for="UserName" class="form-label fs-4 text-light px-1">Username</label>
                      <input type="text" class="form-control py-3 fs-4 user--name" id="UserName" placeholder="Username" disabled="true"
                        value="<?php echo $username;?>"
                      >
                    </div>
                    <div class="col">
                        <label for="PassWord" class="form-label fs-4 text-light px-1">Password</label>
                        <input type="password" class="form-control py-3 fs-4 user--pass" id="PassWord" placeholder="Password" disabled="true"
                            value="<?php echo $password; ?>"
                        >
                      </div>
                </div>               
            </div>
        </div>
    </div>
</div>
<!--END OF PROFILE SECTION-->

<!--ORDER HISTORY SECTION-->
<div data-bs-spy="scroll" data-bs-target="#orderLink" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollpsy-example" tabindex="0">
    <div class="container-fluid pt-5 h-100 w-100 mt-0 table--container" id="orderHistory">
        <ul class="nav nav-tabs dash--tabs">
            <li class="nav-item title--place">
                <div class="nav-link fs-3 text-bg-dark dash--title" aria-current="page">ORDER HISTORY</div>
            </li>
        </ul>
        <table class="table table-bordered fs-5 mt-0 text-center dash--table">
            <thead>
                <tr class="">
                    <th scope="col" class="col-2 bg-primary text-light">Product</th>
                    <th scope="col" class="bg-primary text-light ">Order Type</th>
                    <th scope="col" class="bg-primary text-light ">Order Date</th>
                    <th scope="col" class="bg-primary text-light ">Price</th>
                    <th scope="col" class="bg-primary text-light ">Quantity</th>
                    <th scope="col" class="bg-primary text-light ">Total Amount</th>
                    <th scope="col" class="bg-primary text-light ">Order Status</th>
                </tr>
            </thead>
            <tbody>
                <?php include "handleOrders.php"; ?>
            </tbody>
        </table>
    </div>
</div>
<!--END OF ORDER HISTORY SECTION-->

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
        
        
        
        
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    

    
</body>
</html>


