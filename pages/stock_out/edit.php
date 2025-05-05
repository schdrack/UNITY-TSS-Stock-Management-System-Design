<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/functions.php';

redirectIfNotLoggedIn();

if (!isset($_GET['id'])) {
    header("Location: view.php");
    exit();
}

$id = (int)$_GET['id'];
$record = $conn->query("SELECT * FROM ProductOut WHERE ProductOut_id = $id")->fetch_assoc();

if (!$record) {
    header("Location: view.php");
    exit();
}

$products = $conn->query("SELECT * FROM Products ORDER BY PName");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pcode = sanitizeInput($conn, $_POST['pcode']);
    $date = sanitizeInput($conn, $_POST['date']);
    $quantity = (int)sanitizeInput($conn, $_POST['quantity']);
    $price = (float)sanitizeInput($conn, $_POST['price']);
    $total = $quantity * $price;

    $stmt = $conn->prepare("UPDATE ProductOut SET PCode=?, prOut_Date=?, prOut_Quantity=?, prOut_unit_Price=?, prOut_TotalPrice=? WHERE ProductOut_id=?");
    $stmt->bind_param("ssiddi", $pcode, $date, $quantity, $price, $total, $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Stock out record updated successfully!";
        header("Location: view.php");
        exit();
    } else {
        $error = "Error updating record: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Stock Out - UNITY TSS</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php include __DIR__ . '/../../includes/nav.php'; ?>
    
    <div class="container">
        <h1>Edit Stock Out Record</h1>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Product</label>
                <select name="pcode" required class="form-control">
                    <?php while ($product = $products->fetch_assoc()): ?>
                        <option value="<?= $product['PCode'] ?>" <?= $product['PCode'] == $record['PCode'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($product['PName']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Date</label>
                <input type="date" name="date" value="<?= $record['prOut_Date'] ?>" required class="form-control">
            </div>
            
            <div class="form-group">
                <label>Quantity</label>
                <input type="number" name="quantity" min="1" value="<?= $record['prOut_Quantity'] ?>" required class="form-control">
            </div>
            
            <div class="form-group">
                <label>Unit Price (RWF)</label>
                <input type="number" name="price" step="0.01" min="0.01" value="<?= $record['prOut_unit_Price'] ?>" required class="form-control">
            </div>
            
            <div class="form-group">
                <label>Total Price (RWF)</label>
                <input type="text" name="total" value="<?= $record['prOut_TotalPrice'] ?>" readonly class="form-control" id="total-price">
            </div>
            
            <button type="submit" class="btn btn-primary">Update Record</button>
            <a href="view.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script>
        // Calculate total price automatically
        document.querySelectorAll('input[name="quantity"], input[name="price"]').forEach(input => {
            input.addEventListener('input', function() {
                const quantity = parseFloat(document.querySelector('input[name="quantity"]').value) || 0;
                const price = parseFloat(document.querySelector('input[name="price"]').value) || 0;
                document.getElementById('total-price').value = (quantity * price).toFixed(2);
            });
        });
    </script>
</body>
</html>