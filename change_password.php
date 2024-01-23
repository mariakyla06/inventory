<?php
session_start();
// Include ang iyong database connection
// include("inventory");

// Connect to the database
    //  $conn = new mysqli("localhost", "root", "", "inventory"); //localDatabase
    $conn = new mysqli("localhost", "u542620504_supplyimsAdmin", "Supplyinformationsystem@2024", "u542620504_supplyims"); //devsiteDatabase

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kunin ang input mula sa form
$user_id = $_POST['user_id'];
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_new_password = $_POST['confirm_new_password'];

// Verify ang kasalukuyang password
$query = "SELECT password FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $stored_password = $row['password'];

    // if (password_verify($current_password, $stored_password)) {
    if ($current_password == $stored_password) {
        // Kasalukuyang password ay tama
        // Tiyakin na bagay ang bagong password at kumpirmasyon
        if ($new_password == $confirm_new_password) {
            // Baguhin ang password sa database
            // $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_query = "UPDATE users SET `password` = '$new_password' WHERE `id` = $user_id";
            mysqli_query($conn, $update_query);

            unset($_SESSION['user_data']);
            echo "<script>alert('Password successfully changed.'); window.location='setting.php';</script>";

        } else {
            echo "New password and confirmation do not match.";
        }
    } else {
        echo "Incorrect current password.";
    }
} else {
    echo "Error retrieving user data.";
}

// Isara ang database connection
mysqli_close($conn);
?>
