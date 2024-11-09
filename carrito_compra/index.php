<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'functions.php';

//inicio de sesión
session_start();

login();

$product_name = $_GET['name'];
$action = $_GET['action'];




?>