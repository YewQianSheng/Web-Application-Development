<?php
session_start();
if (!isset($_SESSION["customer_id"])) {
    header('Location: login_page.php');
    exit();
}
$logout = isset($_GET['logout']) ? $_GET['logout'] : "";
if ($logout == "true") {
    session_unset();
    session_destroy();
    header("Location: homepage.php");
    exit();
}
