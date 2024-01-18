<?php
session_start();
date_default_timezone_set('Asia/Manila');

spl_autoload_register(function ($class) {
    include '../models/' . $class . '.php';
});

$today = date('Y-m-d H:i:s');
$order = new Order;
$product = new Product;
$product_transaction = new ProductTransaction;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $order_id = filter_input(INPUT_POST, 'order_id', FILTER_SANITIZE_NUMBER_INT);
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
    $ordered_quantity = filter_input(INPUT_POST, 'ordered_quantity', FILTER_SANITIZE_STRING);

    if($status == "CLAIMED"){
        $currentProduct = $product->find($product_id);
        $currentProductQty = $currentProduct->qty;
        
        $orderedProduct =  $order->find($order_id);
        $orderedProductQty = $orderedProduct->quantity;

        if( $orderedProductQty > $currentProductQty ){ // Early exit kung mag true.
            echo "<script>alert('Insufficient Stock for the ordered product.'); window.location='../orders.php';</script>";
            exit();
        }else{
            $currentProductQty = $currentProductQty - $orderedProductQty;
        }
    }

    try {

        $orderStmt = $order->pdo->prepare("UPDATE orders SET status = :status WHERE id = :order_id");
    
        // Bind parameters to your SQL statement
        $orderStmt->bindParam(':status', $status);
        $orderStmt->bindParam(':order_id', $order_id);
        $orderStmt->execute();

        if($status == "CLAIMED"){
            // Update product Value;
            $productStmt = $product->pdo->prepare("UPDATE product SET qty = :currentProductQty WHERE id = :product_id");
             // Bind parameters to your SQL statement
            $productStmt->bindParam(':currentProductQty', $currentProductQty);
            $productStmt->bindParam(':product_id', $product_id);
            $productStmt->execute();

            //Add value in Product Transaction history
            $type = "OUT";
            $prodTransactionStmt = $product_transaction->pdo->prepare("INSERT INTO product_transactions (type, order_id, created_at, updated_at ) VALUES (:type, :order_id, :today, :today)");
            $prodTransactionStmt->bindParam(':type', $type);
            $prodTransactionStmt->bindParam(':order_id', $order_id);
            $prodTransactionStmt->bindParam(':today', $today);
            $prodTransactionStmt->execute();

        }

        echo "<script>alert('Status has been Updated !'); window.location='../approved_products.php';</script>";

    } catch (\PDOException  $e) {
        // die('Database connection error: ' . $e->getMessage());
        echo "<script>alert('Something Went Wrong !'); window.location='../clients.php';</script>";
    }

 

}
