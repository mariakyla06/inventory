<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize user input
    $username = htmlspecialchars($_POST['username']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $npass = $_POST['npass'];
    $rpass = $_POST['rpass'];

    // Validate password match
    if ($npass !== $rpass) {
        echo "<script>alert('Error: Passwords do not match!'); window.location='setting.php';</script>";
        exit(); 
    }

    // Connect to the database
    // $conn = new mysqli("localhost", "root", "", "inventory"); //localDatabase
    $conn = new mysqli("localhost", "u542620504_supplyimsAdmin", "Supplyinformationsystem@2024", "u542620504_supplyims"); //devsiteDatabase

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the username already exists
    $checkUsernameStmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $checkUsernameStmt->bind_param("s", $username);
    $checkUsernameStmt->execute();
    $checkUsernameResult = $checkUsernameStmt->get_result();

    if ($checkUsernameResult->num_rows != 1) {
        echo "<script>alert('Error: Username doesn't exist!'); window.location='setting.php';</script>";
        exit(); // Stop execution if the username doesn't exist
    }

    // Check if the email already exists
    $checkEmailStmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $checkEmailStmt->bind_param("s", $email);
    $checkEmailStmt->execute();
    $checkEmailResult = $checkEmailStmt->get_result();

    if ($checkEmailResult->num_rows != 1) {
        echo "<script>alert('Error: Email doesn't exist!'); window.location='setting.php';</script>";
        exit(); // Stop execution if the email doesn't exist
    }

    // Continue with the password change process

    // Use prepared statements to prevent SQL injection
    $updateStmt = $conn->prepare("UPDATE users SET password=? WHERE email=? AND username=?");
    $updateStmt->bind_param("sss", $npass, $email, $username);

    // Execute the statement
    if ($updateStmt->execute()) {
        echo "<script>alert('Change password successful!'); window.location='setting.php';</script>";
        exit(); // Ensure that no other code is executed after the redirect
    } else {
        echo "<script>alert('Changing password failed. Please try again later.'); window.location='setting.php';</script>";
    }

    // Close the statements and connection
    $updateStmt->close();
    $checkUsernameStmt->close();
    $checkEmailStmt->close();
    $conn->close();
}
?>
