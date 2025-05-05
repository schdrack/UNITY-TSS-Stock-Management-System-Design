<?php
require_once '../../config/db.php';
require_once '../../includes/auth.php';

if (!isLoggedIn()) {
    header('Location: ../../pages/login.php');
    exit();
}

$products = $conn->query("SELECT * FROM Products");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pcode = $conn->real_escape_string($_POST['pcode']);
    $date = $conn->real_escape_string($_POST['date']);
    $quantity = $conn->real_escape_string($_POST['quantity']);
    $price = $conn->real_escape_string($_POST['price']);
    $total = $quantity * $price;
    
    $sql = "INSERT INTO ProductIn (PCode, prIn_Date, prIn_Quantity, prIn_Unit_Price, prIn_TotalPrice) 
            VALUES ('$pcode', '$date', '$quantity', '$price', '$total')";
            
    if ($conn->query($sql)) {
        header('Location: ../view.php');
        exit();
    } else {
        $error = "Error recording stock in: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Stock In</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/nav.php'; ?>
    
    <div class="container">
        <h1>Record Stock In</h1>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Product</label>
                <select name="pcode" required>
                    <option value="">Select Product</option>
                    <?php while ($product = $products->fetch_assoc()): ?>
                        <option value="<?php echo $product['PCode']; ?>">
                            <?php echo $product['PName']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Date</label>
                <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Quantity</label>
                <input type="number" name="quantity" min="1" required>
            </div>
            
            <div class="form-group">
                <label>Unit Price</label>
                <input type="number" name="price" min="0.01" step="0.01" required>
            </div>
            
            <button type="submit">Record Stock In</button>
            <a href="../view.php" class="btn">Cancel</a>
        </form>
    </div>
    
    <script src="../../assets/js/script.js"></script>
</body>
</html>