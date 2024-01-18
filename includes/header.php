<?php
    session_start();
    if( !isset($_SESSION['user_data']) ) {
        header('Location: index.php');
    } 

    spl_autoload_register(function ($class) {
        include 'models/' . $class . '.php';
    });

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>CVSU Inventory</title>
    <link rel="stylesheet" href="home.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>