<?php
require_once '../../config/db.php';
require_once '../../includes/auth.php';

// Check if user is logged in
redirectIfNotLoggedIn();

// Check if ID parameter exists
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "Invalid request. No record specified.";
    header('Location: view.php');
    exit();
}

// Sanitize the ID
$id = (int)$_GET['id'];

// Check if the record exists
$sql = "SELECT * FROM ProductIn WHERE ProductIn_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "Record not found.";
    header('Location: view.php');
    exit();
}

// Delete the record
$delete_sql = "DELETE FROM ProductIn WHERE ProductIn_id = ?";
$delete_stmt = $conn->prepare($delete_sql);
$delete_stmt->bind_param("i", $id);

if ($delete_stmt->execute()) {
    $_SESSION['success'] = "Stock-in record deleted successfully.";
} else {
    $_SESSION['error'] = "Error deleting record: " . $conn->error;
}

$delete_stmt->close();
$conn->close();

// Redirect back to view page
header('Location: view.php');
exit();
?>