<?php
session_start();

$host = "localhost";
$user_db = "root";
$pass_db = "";
$name_db = "bwrs";
$tableName = "customer";

// Error and exception handling for database connection
$conn = new mysqli($host, $user_db, $pass_db, $name_db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

try {
    // Check if userId is set in the session
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        
        // Fetch user data from the database using the retrieved userId from the session
        $sql_user = "SELECT user_id, username, firstname, lastname, address, con_number, password, user_role, user_image FROM $tableName WHERE user_id = $userId";

        // Using prepared statement to prevent SQL injection
        $stmt = $conn->prepare($sql_user);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                $userid = $row["user_id"];
                $username = $row["username"];
                $user_image = '../' . $row["user_image"];
                $firstname = $row["firstname"];
                $lastname = $row["lastname"];
                $address = $row["address"];
                $phone_no = $row["con_number"];
                $password = $row["password"];
                $user_role = strtoupper($row["user_role"]);
            }
        } else {
            echo "0 results";
        }

        $stmt->close();
    } else {
        echo "<script>console.log('why?');</script>";
    }
} catch (Exception $e) {
    // Handle any unexpected exceptions
    echo "Error: " . $e->getMessage();
} finally {
    // Close the database connection
    $conn->close();
}
?>
