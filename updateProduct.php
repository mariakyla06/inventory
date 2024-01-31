<?php
date_default_timezone_set('Asia/Manila');
$today = date('Y-m-d H:i:s');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize user input
    $barcodeId = $_POST['barcodeId'];
    $qty = $_POST['qty'];
    $id;


    // Connect to the database
    include("connection.php");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SELECT statement
    $selectStmt = $conn->prepare("SELECT id FROM product WHERE barcodeId = ?");
    $selectStmt->bind_param("s", $barcodeId);

    // Execute the SELECT statement
    $selectStmt->execute();

    // Bind the result to a variable
    $selectStmt->bind_result($id);

    // Fetch the result. This will populate $id with the value from the database
    $selectStmt->fetch();

    // Now you can use $id in your code

    // Don't forget to close the statement when you're done
    $selectStmt->close();


    // Check if the product with the given barcodeId exists
    $checkProductStmt = $conn->prepare("SELECT * FROM product WHERE barcodeId = ?");
    $checkProductStmt->bind_param("i", $barcodeId);
    $checkProductStmt->execute();
    $checkProductResult = $checkProductStmt->get_result();

    // Check if the product exists
    if ($checkProductResult->num_rows > 0) {
        // Update the quantity of the product
        

        $conn->begin_transaction();

        try {
            // Use prepared statements to prevent SQL injection

            $updateQtyStmt = $conn->prepare("UPDATE product SET qty = qty + ? WHERE barcodeId = ? AND id = ?");
            $updateQtyStmt->bind_param("isi", $qty, $barcodeId, $id);

            // Execute the statement
            if (!$updateQtyStmt->execute()) {
                throw new Exception("Error during execution: " . $updateQtyStmt->error);
            }

            $restock_orders_type = 'UPDATE';
            $stmt2 = $conn->prepare("INSERT INTO restock_orders (`product_id`, `quantity`, `type`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, ?)");
            $stmt2->bind_param("sisss", $id, $qty,$restock_orders_type, $today, $today);

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

            echo "<script>alert('Product Saved!'); window.location='product.php';</script>";
            exit(); // Ensure that no other code is executed after the redirect
        } catch (Exception $e) {
            // An error occurred, rollback the transaction and show the error message
            $conn->rollback();
            echo $e->getMessage();
            exit();
        }

        // Execute the statement
        if ($updateQtyStmt->execute()) {
            echo "<script>alert('Product quantity updated!'); window.location='stocks.php';</script>";
            exit();
        } else {
            echo "<script>alert('Failed to update product quantity!'); window.location='stocks.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Error: Product doesn\'t exist!'); window.location='stocks.php';</script>";
        exit();
    }

    // Close the statements and connection
    $checkProductStmt->close();
    $updateQtyStmt->close();
    $stmt2->close();
    $stmt3->close();
    $conn->close();
}
?>
