<?php
session_start();
date_default_timezone_set('Asia/Manila');

spl_autoload_register(function ($class) {
    include '../models/' . $class . '.php';
});

$today = date('Y-m-d H:i:s');
$instance = new Order;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mappedOrders = array();
    foreach($_POST as $key => $value) {
        // Split the key into name and index
        list($name, $index) = explode('_', $key);
        
        // Initialize the sub-array if it doesn't exist
        if (!isset($mappedOrders[$index])) {
            $mappedOrders[$index] = array();
        }
        
        // Add the value to the sub-array
        $mappedOrders[$index][$name] = $value;
    }

    foreach ($mappedOrders as $key => $order) {
        if(!isset($order['id']) || !$order['id']){
            echo "<script>alert('Please complete the product selection.'); window.location='../orders.php';</script>";
            exit();
        }
    }

    foreach ($mappedOrders as $key => $order) {
        

        try {
            $status = 'PENDING';
            $ordered_by = $_SESSION['user_data']->client_login ? $_SESSION['user_data']->id : $_SESSION['user_data']['id'];
            // Prepare your SQL statement
            $stmt = $instance->pdo->prepare("INSERT INTO orders (`product_id`, `quantity`, `office`, `remarks`, `status`, `ordered_by`) VALUES (:product_id, :quantity, :office, :remarks, :status, :ordered_by)");

            // Bind parameters to your SQL statement
            $stmt->bindParam(':product_id', $order['id']);
            $stmt->bindParam(':quantity', $order['quantity']);
            $stmt->bindParam(':office', $order['office']);
            $stmt->bindParam(':remarks', $order['remarks']);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':ordered_by', $ordered_by);
            $stmt->execute();

            echo "<script>alert('Order has been sent !'); window.location='../orders.php';</script>";

        } catch (\PDOException  $e) {
            die('Database connection error: ' . $e->getMessage());
            echo "<script>alert('Something Went Wrong !'); window.location='../orders.php';</script>";
        }
    }

   
}
?>
