<?php
// Database credentials
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "bwrs";

// Establish database connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Function to display notification
function displayNotification($message, $type) {
    $notificationClass = ($type === 'success') ? 'success' : 'error';
    echo '<div class="notification ' . $notificationClass . '">' . $message . '</div>';
}

function sanitizeInput($input) {
    // Sanitize the input using appropriate methods (e.g., mysqli_real_escape_string)
    global $conn;
    return mysqli_real_escape_string($conn, $input);
}

function verifyLogin($username, $password, $table) {
    global $conn;
    $username = sanitizeInput($username);
    $password = sanitizeInput($password);

    $query = "SELECT * FROM $table WHERE username = '$username' AND password = '$password'"; //sql statement to acquire the requested queries from the database
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        return true; // Login successful for customer and employees
    } else {
        return false; // Login failed for customers and employees
    }
}


if (isset($_POST['LoginButton'])) {
    $username = $_POST['userName'];
    $password = $_POST['passWord'];

    if (verifyLogin($username, $password, 'customer')) {
        displayNotification("Customer login sucess!", "success");
        clearFormFields();
        // Redirect to customer dashboard or desired page
    } elseif (verifyLogin($username, $password, 'employee')) {
        displayNotification("Employee login sucess!", "success");
        clearFormFields();
        // Redirect to employee dashboard or desired page
    } else {
        displayNotification("Invalid username or password!", "error");
        clearFormFields();
        // Display error message or redirect to login page with error
    }

}
function clearFormFields() {
    // Clear input fields
    $_POST['username'] = '';
    $_POST['password'] = '';
}



$conn->close();





?>