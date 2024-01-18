<?php
session_start();
date_default_timezone_set('Asia/Manila');

spl_autoload_register(function ($class) {
    include '../models/' . $class . '.php';
});

header('Content-Type: application/json; charset=utf-8');

$instance = new Product;

$products = $instance->all();
http_response_code(200);
echo json_encode(array('message' => 'Success', 'data' => $products ));
exit();