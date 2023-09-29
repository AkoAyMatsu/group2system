<!--php file to handle the client-side-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="register.css">
    <title>BANI WATER REFILLING STATION</title>
</head>
<body bgcolor="lightblue">
<div class="container">
    <div class="placeBox">
    <div class="divider"></div>
    <img class="waterImg" src="imgs_register/delivery_boy.png" alt="Water Image">
    <div class="welcomeText">SIGN UP</div>

    <form id="signup-form" method="POST" enctype="multipart/form-data">

        <!--First Name-->
        <div class="fname">
            <input type="text" placeholder="First name" name="firstname" class="first-name">
            <div id="firstname-validation" class="validation-message"></div>
        </div><br>
        <!--Last Name-->
        <div class="lname">
            <input type="text" placeholder="Last Name" name="lastname"></div><br>
        <div class="home_ad">
            <input type="text" placeholder="Address" name="address"></div><br>
        <div class="contact_no">
            <input type="text" placeholder="Contact Number" name="con_number" pattern="[0-9]+" oninput="handleContactNumberInput(this)"></div><br>
        <div class="uname">
            <input type="text" placeholder="New Username" name="username"></div><br>
        <div class="pswd">
            <input type="password" placeholder="New Password" name="password"></div>
            <span class="passwordToggle"></span>
        <div class="role">
            <select name="user_role" onchange="removeDefaultOption(this)">
                <option value="Default" disabled selected hidden>--USER ROLE--</option>
                <option value="Customer" <?php if (isset($_POST['user_role']) && $_POST['user_role'] === 'Customer') echo 'selected'; ?>>CUSTOMER</option>
                <option value="Employee" <?php if (isset($_POST['user_role']) && $_POST['user_role'] === 'Employee') echo 'selected'; ?>>EMPLOYEE</option>
            </select>
        </div>
        <div class="upload-container">
            <input type="file" id="file-upload" name="profileImg" accept="image/*">
            <label for="file-upload" class="upload-button">
            <img id="preview-image" class="uploaded-image">
            <span class="plus-icon">+</span>
            <span class="upload-text">Add profile image</span>
            </label>
        </div>
        <div class="regBtn"><button id="signup-button" name="SignUpButton">Sign-Up</button></div>
        </form>
        <img class="backIcon" src="imgs_register/back_button_icon.png" alt="Back Icon"></br>
        <div class="backToLoginText"><a href="login.php">Back to login</a></div>
    </div>
</div>
<script src="register.js"></script>
</body>
</html>

<?php

    require_once "handleRegister.php";

?>
