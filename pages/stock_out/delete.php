<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/functions.php';

redirectIfNotLoggedIn();

if (!isset($_GET['id'])) {
    $_SESSION['error'] = "Invalid request. No record specified.";
    header("Location: view.php");
    exit();
}

$id = (int)$_GET['id'];

// Verify record exists
$record = $conn->query("SELECT * FROM ProductOut WHERE ProductOut_id = $id")->fetch_assoc();

if (!$record) {
    $_SESSION['error'] = "Record not found or already deleted.";
    header("Location: view.php");
    exit();
}

// Delete the record
if ($conn->query("DELETE FROM ProductOut WHERE ProductOut_id = $id")) {
    $_SESSION['success'] = "Stock out record deleted successfully!";
} else {
    $_SESSION['error'] = "Error deleting record: " . $conn->error;
}

header("Location: view.php");
exit();
?>