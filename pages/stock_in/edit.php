<?php
require_once '../../config/db.php';
require_once '../../includes/auth.php';

redirectIfNotLoggedIn();

if (!isset($_GET['id'])) {
    header('Location: view.php');
    exit();
}

$id = $_GET['id'];
$record = $conn->query("SELECT * FROM ProductIn WHERE ProductIn_id = $id")->fetch_assoc();

if (!$record) {
    header('Location: view.php');
    exit();
}

$products = $conn->query("SELECT * FROM Products");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pcode = sanitizeInput($conn, $_POST['pcode']);
    $date = sanitizeInput($conn, $_POST['date']);
    $quantity = sanitizeInput($conn, $_POST['quantity']);
    $price = sanitizeInput($conn, $_POST['price']);
    $total = $quantity * $price;
    
    $sql = "UPDATE ProductIn SET 
            PCode = '$pcode',
            prIn_Date = '$date',
            prIn_Quantity = '$quantity',
            prIn_Unit_Price = '$price',
            prIn_TotalPrice = '$total'
            WHERE ProductIn_id = $id";
            
    if ($conn->query($sql)) {
        header('Location: view.php');
        exit();
    } else {
        $error = "Error updating record: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Stock In</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/nav.php'; ?>
    
    <div class="container">
        <h1>Edit Stock In Record</h1>
        
        <?php if (isset($error)) displayError($error); ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Product</label>
                <select name="pcode" required>
                    <?php while ($product = $products->fetch_assoc()): ?>
                        <option value="<?= $product['PCode'] ?>" 
                            <?= $product['PCode'] == $record['PCode'] ? 'selected' : '' ?>>
                            <?= $product['PName'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Date</label>
                <input type="date" name="date" value="<?= $record['prIn_Date'] ?>" required>
            </div>
            
            <div class="form-group">
                <label>Quantity</label>
                <input type="number" name="quantity" value="<?= $record['prIn_Quantity'] ?>" min="1" required>
            </div>
            
            <div class="form-group">
                <label>Unit Price</label>
                <input type="number" name="price" value="<?= $record['prIn_Unit_Price'] ?>" min="0.01" step="0.01" required>
            </div>
            
            <button type="submit" class="btn">Update Record</button>
            <a href="view.php" class="btn">Cancel</a>
        </form>
    </div>
</body>
</html>