<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/functions.php';

// Debug connection
if (!$conn) {
    die("Database connection failed: " . $conn->connect_error);
}

redirectIfNotLoggedIn();

// Debug: Check if products query works
$products = $conn->query("SELECT * FROM Products ORDER BY PName");
if (!$products) {
    die("Products query failed: " . $conn->error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debug POST data
    echo "<pre>POST Data: ";
    print_r($_POST);
    echo "</pre>";
    
    $pcode = sanitizeInput($conn, $_POST['pcode'] ?? '');
    $date = sanitizeInput($conn, $_POST['date'] ?? '');
    $quantity = (int)sanitizeInput($conn, $_POST['quantity'] ?? 0);
    $price = (float)sanitizeInput($conn, $_POST['price'] ?? 0);
    $total = $quantity * $price;

    // Debug SQL
    $sql = "INSERT INTO ProductOut (PCode, prOut_Date, prOut_Quantity, prOut_unit_Price, prOut_TotalPrice) VALUES (?, ?, ?, ?, ?)";
    echo "<pre>SQL: $sql</pre>";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("ssidd", $pcode, $date, $quantity, $price, $total);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Stock out recorded successfully!";
        header("Location: view.php");
        exit();
    } else {
        die("Execute failed: " . $stmt->error);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Stock Out - UNITY TSS</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>
    <!-- Rest of your HTML remains the same -->
</body>
</html>