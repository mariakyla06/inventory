<?php
session_start();
date_default_timezone_set('Asia/Manila');

spl_autoload_register(function ($class) {
    include '../models/' . $class . '.php';
});

$today = date('Y-m-d H:i:s');
$instance = new Client;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize POST data
    $employee_id = filter_input(INPUT_POST, 'employee_id', FILTER_SANITIZE_STRING);
    $employee_name = filter_input(INPUT_POST, 'employee_name', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $confirm_password = filter_input(INPUT_POST, 'confirm-password', FILTER_SANITIZE_STRING);
    $contact = filter_input(INPUT_POST, 'contact', FILTER_SANITIZE_STRING);

    if ($password != $confirm_password) {
        echo "<script>alert('Passwords do not match'); window.location='../clients.php';</script>";
    }

    // Check if employee_id already exists
    $employee = $instance->setQuery("SELECT * FROM clients WHERE employee_id = '$employee_id'")->getFirst();

    if($employee->id){
        echo "<script>alert('Client Already Exist !'); window.location='../clients.php';</script>";
    }

    try {
        $instance->setQuery(" INSERT INTO clients ( `employee_id`, `password`, `name`, `contact`, `created_at`, `updated_at`)
                            VALUES ( '$employee_id', '$password', '$employee_name', '$contact', '$today', '$today'); ");

        echo "<script>alert('Successfully Created Client !'); window.location='../clients.php';</script>";

    } catch (\PDOException  $e) {
        die('Database connection error: ' . $e->getMessage());
        echo "<script>alert('Something Went Wrong !'); window.location='../clients.php';</script>";
    }

    exit();

}
