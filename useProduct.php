<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize user input
    $barcodeId = $_POST['barcodeId'];
    $qty = $_POST['qty'];

    // Connect to the database
    include("connection.php");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the product with the given barcodeId exists
    $checkProductStmt = $conn->prepare("SELECT * FROM product WHERE barcodeId = ?");
    $checkProductStmt->bind_param("i", $barcodeId);
    $checkProductStmt->execute();
    $checkProductResult = $checkProductStmt->get_result();

    // Check if the product exists
    if ($checkProductResult->num_rows > 0) {
        // Update the quantity of the product
        $updateQtyStmt = $conn->prepare("UPDATE product SET qty = qty - ? WHERE barcodeId = ?");
        $updateQtyStmt->bind_param("ii", $qty, $barcodeId);

        // Execute the statement
        if ($updateQtyStmt->execute()) {
            echo "<script>alert('Product quantity updated!'); window.location='product.php';</script>";
            exit();
        } else {
            echo "<script>alert('Failed to update product quantity!'); window.location='product.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Error: Product doesn\'t exist!'); window.location='product.php';</script>";
        exit();
    }

    // Close the statements and connection
    $checkProductStmt->close();
    $updateQtyStmt->close();
    $conn->close();
}
?>
