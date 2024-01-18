<?php
session_start();
date_default_timezone_set('Asia/Manila');

spl_autoload_register(function ($class) {
    include '../models/' . $class . '.php';
});

$today = date('Y-m-d H:i:s');
$instance = new Client;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $employee_id = filter_input(INPUT_POST, 'employee_id', FILTER_SANITIZE_NUMBER_INT);

    try {
        $instance->setQuery("UPDATE clients SET `deleted_at` = '$today'  WHERE `id` = $employee_id");

        echo "<script>alert('Successfully Deleted Client  Info !'); window.location='../clients.php';</script>";

    } catch (\PDOException  $e) {
        die('Database connection error: ' . $e->getMessage());
        echo "<script>alert('Something Went Wrong !'); window.location='../clients.php';</script>";
    }

    exit();

}
