<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize user input
    $username = htmlspecialchars($_POST['username']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // Validate password match
    if ($password !== $cpassword) {
        echo "<script>alert('Passwords do not match!'); window.location='setting.php';</script>";
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
    $checkStmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        echo "<script>alert('Error: Username already exists!'); window.location='setting.php';</script>";
    } else {
        // Continue with the registration process

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>alert('Registration successful!'); window.location='index.php';</script>";
            exit(); 
        } else {
            echo "<script>alert('Registration failed. Please try again later'); window.location='setting.php';</script>";
            exit(); 
        }

        // Close the statement
        $stmt->close();
    }

    // Close the statement and connection
    $checkStmt->close();
    $conn->close();
}
?>
