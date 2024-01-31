<?php
session_start();
date_default_timezone_set('Asia/Manila');

spl_autoload_register(function ($class) {
    include '../models/' . $class . '.php';
});

$today = date('Y-m-d H:i:s');
$instance = new Client;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $employee_id = filter_input(INPUT_POST, 'employee_id', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        // Check if employee_id already exists
        $employee = $instance->setQuery("SELECT * FROM clients WHERE `employee_id` = '$employee_id' AND `password` = '$password' AND `deleted_at` IS NULL")->getFirst();

        if(isset($employee->id) && $employee->id){
            $_SESSION['user_data'] = $employee;
            $_SESSION['user_data']->client_login = true;

            echo "<script>alert('Client Login Successfully !'); window.location='../clients.php';</script>";
        }else {
            echo "<script>alert('Login failed. Check your employee id and password.'); window.location='../index.php';</script>";

        }
}