<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BANI WATER REFILLING STATION</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body bgcolor="lightblue">
<div class="container">
<div class="placeBox">
<div class="divider"></div>
<img class="waterImg" src="imgs_login\delivery_boy.png" alt="Water Image">
<div class="welcomeText">WELCOME BACK</div>
<div class="usernameText">Username</div>
<div class="passwordText">Password</div>


    <form method="POST">
        <div class="uname"><input type="text" placeholder="Enter your username" name="userName">
            <img class="usernameIcon" src="imgs_login\user_icon.png" alt="Username Icon">
        </div>
        <div class="pswd"><input type="password" placeholder="Enter your password" name="passWord">
        <span class="passwordToggle"></span>

        <div class="logInBtn"><button type="submit" name="LoginButton">Login</button></div>
        </div>

    </form>
    <div class="signUpText">Don't have an account? <br></div>
    <div class="signUpLink"><a href="register.php">Sign-Up Here</a></div>
    </div>
    </div>
<script src="login.js"></script>
</body>
</html>

<?php
    require_once "handleLogin.php";
?>
