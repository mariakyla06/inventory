<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Connect to the database
    // $conn = new mysqli("localhost", "root", "", "inventory"); //localDatabase
    $conn = new mysqli("localhost", "u542620504_supplyimsAdmin", "Supplyinformationsystem@2024", "u542620504_supplyims"); //devsiteDatabase

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM users WHERE username=? AND password=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if the user exists in the database
    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
        $_SESSION['user_data'] = $user_data;

        echo "<script>alert('Login successful!'); window.location='product.php';</script>";
        exit(); // Ensure that no other code is executed after the redirect
    } else {
        echo "<script>alert('Login failed. Check your username and password.'); window.location='index.php';</script>";
        exit(); // Ensure that no other code is executed after the redirect
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
