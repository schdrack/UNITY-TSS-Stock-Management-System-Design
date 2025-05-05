<?php
require_once '../../config/db.php';
require_once '../../includes/auth.php';

redirectIfNotLoggedIn();

if (!isset($_GET['id'])) {
    header('Location: view.php');
    exit();
}

$id = $_GET['id'];

// Check if product exists
$product = $conn->query("SELECT * FROM Products WHERE PCode = $id")->fetch_assoc();
if (!$product) {
    header('Location: view.php');
    exit();
}

// Delete product
$conn->query("DELETE FROM Products WHERE PCode = $id");
header('Location: view.php');
exit();
?>