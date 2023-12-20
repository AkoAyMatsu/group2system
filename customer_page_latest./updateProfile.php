<?php
// Function to display notification
function displayNotification($message, $type)
{
    $notificationClass = ($type === 'success') ? 'success' : 'error';
    echo '<div class="notification ' . $notificationClass . '">' . $message . '</div>';
}

// Check if the form is submitted
if (isset($_POST['updateProfileButton'])) {
    

    // Retrieve form data
    $firstname = $_POST['fname'];
    $lastname = $_POST['lname'];
    $address = $_POST['home_address'];
    $contactNumber = $_POST['phone_number'];
    $username = $_POST['uname'];
    $password = $_POST['pword'];

    $img_user = $_FILES['profile_image'];
    
    $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
    $fileExtension = strtolower(pathinfo($img_user['name'], PATHINFO_EXTENSION));

    // Check if there is a file uploaded
                    // Additional validation for file upload

    if (empty($firstname) || empty($lastname) || empty($address) || empty($contactNumber) ||
        empty($username) || empty($password)) {
        displayNotification("Please fill in all fields!", "error");
    } elseif (strlen($contactNumber) !== 11 || !ctype_digit($contactNumber)) {
        displayNotification("Invalid contact number format!", "error");
    } elseif (strlen($password) < 8 || strlen($password) > 20) {
        displayNotification("Password should be 8-20 characters long!", "error");
    } else {
        // Database connection
        $servername = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $database = "bwrs";
        $table_name = "customer";

        try {
            $conn = new mysqli($servername, $dbUsername, $dbPassword, $database);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            // Assuming user_id is stored in the session
            if(isset($_SESSION['user_id'])){
                $user_id = $_SESSION['user_id'];

                // SQL injection protection
                $firstname = $conn->real_escape_string($firstname);
                $lastname = $conn->real_escape_string($lastname);
                $address = $conn->real_escape_string($address);
                $contactNumber = $conn->real_escape_string($contactNumber);
                $username = $conn->real_escape_string($username);
                $password = $conn->real_escape_string($password);

                // Check if the username already exists
                $usernameCheckQuery = "SELECT user_id FROM $table_name WHERE username = '$username' AND user_id != '$user_id'";
                $usernameCheckResult = $conn->query($usernameCheckQuery);

                // Check if the contact number already exists
                $contactNumberCheckQuery = "SELECT user_id FROM $table_name WHERE con_number = '$contactNumber' AND user_id != '$user_id'";
                $contactNumberCheckResult = $conn->query($contactNumberCheckQuery);

                if ($usernameCheckResult->num_rows > 0 && $contactNumberCheckResult->num_rows > 0) {
                    displayNotification("Username and contact number already taken!", "error");
                } elseif ($usernameCheckResult->num_rows > 0) {
                    displayNotification("Username already taken!", "error");
                } elseif ($contactNumberCheckResult->num_rows > 0) {
                    displayNotification("Contact number already taken!", "error");
                } else {
                    
                    
                    // Check if there is a file uploaded
                    if (!empty($img_user['name']) && is_uploaded_file($img_user['tmp_name'])) {
                        // Additional validation for file upload (you can uncomment the next line if needed)
                        if (!in_array($fileExtension, $allowedExtensions)) {
                            displayNotification("Invalid image file format!", "error");
                            exit;
                        }
                        $tmpName = $img_user['tmp_name'];

                // Choose a directory to store the uploaded image
                        $uploadDirectory = "../../bwrs/sample_images/CUSTOMER"; // Replace with the actual directory path

                        $imageIdPrefix = "501_";
                        $receiveUserImageId = generateUserImageId($imageIdPrefix);

                        // Generate a unique image filename based on the username
                        $imageFileName = $receiveUserImageId . '_' . $img_user['name'];
                        $imagePath = $uploadDirectory . $imageFileName;

                        // Move the uploaded image to the target directory
                        if (move_uploaded_file($tmpName, $imagePath)) {
                            // Include the image path in the update query
                            $updateQuery = "UPDATE $table_name SET 
                                firstname = '$firstname',
                                lastname = '$lastname',
                                address = '$address',
                                con_number = '$contactNumber',
                                username = '$username',
                                password = '$password',
                                user_image = '$imagePath'
                                WHERE user_id = '$user_id';";

                            if ($conn->query($updateQuery) === TRUE) {
                                // Fetch the updated data from the database
                                $selectUpdatedDataQuery = "SELECT * FROM $table_name WHERE user_id = '$user_id'";
                                $result = $conn->query($selectUpdatedDataQuery);

                                if ($result->num_rows > 0) {
                                    $updatedData = $result->fetch_assoc();
                                    // Return the updated data as JSON
                                    displayNotification("Profile updated successfully!", "success");
                                    $jsonData = json_encode($updatedData);
                                    //echo $jsonData;
                                    echo "<script>console.log('Received JSON data:', " . json_encode($jsonData) . ");</script>";

                                    echo "<script>";
                                    //echo "console.log('Received JSON data:', " . $jsonData . ");";

                                    displayUpdatedData($updatedData);

                                    echo "</script>";
                                } else {
                                    displayNotification("Error fetching updated profile data!", "error");
                                }
                                
                            } else {
                                displayNotification("Error updating profile: " . $conn->error, "error");
                            }
                        } else {
                            displayNotification("Error moving uploaded file to the target directory!", "error");
                        }
                    } else {
                        // No file uploaded, exclude the image path from the update query
                        $updateQuery = "UPDATE $table_name SET 
                            firstname = '$firstname',
                            lastname = '$lastname',
                            address = '$address',
                            con_number = '$contactNumber',
                            username = '$username',
                            password = '$password'
                            WHERE user_id = '$user_id';";

                            if ($conn->query($updateQuery) === TRUE) {
                                // Fetch the updated data from the database
                                $selectUpdatedDataQuery = "SELECT * FROM $table_name WHERE user_id = '$user_id'";
                                $result = $conn->query($selectUpdatedDataQuery);

                                if ($result->num_rows > 0) {
                                    $updatedData = $result->fetch_assoc();
                                    // Return the updated data as JSON
                                    displayNotification("Profile updated successfully!", "success");
                                    $jsonData = json_encode($updatedData);
                                    //echo $jsonData;
                                    echo "<script>console.log('Received JSON data:', " . json_encode($jsonData) . ");</script>";

                                    //echo "<script>console.log('Received JSON data:', " . json_encode($updatedData) . ");</script>";
                                    echo "<script>";
                                    //echo "console.log('Received JSON data:', " . $jsonData . ");";
                                    //echo "document.querySelector('.userImageView').src = '" . $updatedData['user_image'] . "';";

                                    displayUpdatedData($updatedData);

                                    echo "</script>";
                                } else {
                                    displayNotification("Error fetching updated profile data!", "error");
                                }
                               
                            } else {
                                displayNotification("Error updating profile: " . $conn->error, "error");
                            }
                    }
                }
            }
            

            $conn->close();
        } catch (Exception $e) {
            displayNotification("Error: " . $e->getMessage(), "error");
        }
    }
}

function generateUserImageId($prefix){
    $randomIdNumber =  str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);

    $newId = $prefix . $randomIdNumber;

    return $newId;
}

function displayUpdatedData($updatedData){
    // Update the user image if it exists in the data
    if (isset($updatedData['user_image'])) {
        echo "document.querySelector('.userImageView').src = '" . $updatedData['user_image'] . "';";
        echo "document.querySelector('.profile--nav').src = '" . $updatedData['user_image'] . "';";
    }
    echo "document.querySelector('.nav--username').innerText = '" . $updatedData['username'] . "';";
    echo "document.querySelector('.user--welcome').innerText = '" . $updatedData['username'] . "!';";
    echo "document.querySelector('.user--name').innerText = '" . $updatedData['username'] . "';";
    echo "document.querySelector('.profile--name').innerText = '" . $updatedData['username'] . "';";
    echo "document.getElementById('FirstName').value = '" . $updatedData['firstname'] . "';";
    echo "document.getElementById('LastName').value = '" . $updatedData['lastname'] . "';";
    echo "document.getElementById('Address').value = '" . $updatedData['address'] . "';";
    echo "document.getElementById('ContactNumber').value = '" . $updatedData['con_number'] . "';";
    echo "document.getElementById('UserName').value = '" . $updatedData['username'] . "';";
    echo "document.getElementById('PassWord').value = '" . $updatedData['password'] . "';";
}
?>
