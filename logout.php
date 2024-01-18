<?php
session_start();

// print_r($_SESSION['user_data']);
unset($_SESSION['user_data']);
session_destroy();
header('Location: index.php');

