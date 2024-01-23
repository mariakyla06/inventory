<?php
date_default_timezone_set('Asia/Manila');
$today = date('Y-m-d H:i:s');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize user input
    $barcodeId = $_POST['barcodeId'];
    $productName = $_POST['productName'];
    $productGroup = $_POST['productGroup'];
    $qty = $_POST['qty'];
   

    // Connect to the database
   // $conn = new mysqli("localhost", "root", "", "inventory"); //localDatabase
     $conn = new mysqli("localhost", "u542620504_supplyimsAdmin", "Supplyinformationsystem@2024", "u542620504_supplyims"); //devsiteDatabase

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the productId already exists
    $checkproductIdStmt = $conn->prepare("SELECT * FROM product WHERE barcodeId = ?");
    $checkproductIdStmt->bind_param("s", $barcodeId);
    $checkproductIdStmt->execute();
    $checkproductIdResult = $checkproductIdStmt->get_result();

    if ($checkproductIdResult->num_rows > 0) {
        echo "<script>alert('Error: Product ID already exists!'); window.location='barcode.php';</script>";
        exit();
    }else{
        // Start transaction
        $conn->begin_transaction();

        try {
            // Use prepared statements to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO product (`barcodeId`, `productName`, `productGroup`, `qty`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssiss", $barcodeId, $productName, $productGroup, $qty, $today, $today);

            // Execute the statement
            if (!$stmt->execute()) {
                throw new Exception("Error during execution: " . $stmt->error);
            }

            $product_id = $conn->insert_id; 
            $restock_orders_type = 'NEW';
            $stmt2 = $conn->prepare("INSERT INTO restock_orders (`product_id`, `quantity`, `type`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, ?)");
            $stmt2->bind_param("sisss", $product_id, $qty,$restock_orders_type, $today, $today);

            if(!$stmt2->execute()){
                throw new Exception("Error during execution: " . $stmt2->error);
            }

            $last_id = $conn->insert_id; 

            $product_transactions_type = 'IN';
            $stmt3 = $conn->prepare("INSERT INTO product_transactions (type, restock_order_id, created_at, updated_at) VALUES (?, ?, ?, ?)");
            $stmt3->bind_param("siss", $product_transactions_type, $last_id, $today, $today);

            if(!$stmt3->execute()){
                throw new Exception("Error during execution: " . $stmt3->error);
            }

            // If no errors, commit the transaction
            $conn->commit();

            echo "<script>alert('Product Saved!'); window.location='barcode.php';</script>";
            exit(); // Ensure that no other code is executed after the redirect
        } catch (Exception $e) {
            // An error occurred, rollback the transaction and show the error message
            $conn->rollback();
            echo $e->getMessage();
            exit();
        }
    }

    // Close the statements and connection
    $stmt->close();
    $stmt2->close();
    $stmt3->close();
    $checkproductIdStmt->close();
    $checkproductStmt->close();
    $conn->close();
}
?>
