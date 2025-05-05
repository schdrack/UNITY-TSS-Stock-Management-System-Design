<?php
require_once '../../config/db.php';
require_once '../../includes/auth.php';

if (!isLoggedIn()) {
    header('Location: ../../pages/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pname = $conn->real_escape_string($_POST['pname']);
    
    $sql = "INSERT INTO Products (PName) VALUES ('$pname')";
   // In pages/products/add.php, change the redirect to:
if ($conn->query($sql)) {
    header('Location: ' . dirname($_SERVER['PHP_SELF']) . '/view.php');
    exit();
} else {
        $error = "Error adding product: " . $conn->error;
    }
    
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/nav.php'; ?>
    
    <div class="container">
        <h1>Add New Product</h1>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="pname" required>
            </div>
            
            <button type="submit">Add Product</button>
            <a href="../view.php" class="btn">Cancel</a>
        </form>
    </div>
</body>
</html>