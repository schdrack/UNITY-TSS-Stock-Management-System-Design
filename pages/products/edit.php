<?php
require_once '../../config/db.php';
require_once '../../includes/auth.php';
require_once '../../includes/functions.php'; // Add this line to include functions

redirectIfNotLoggedIn();

if (!isset($_GET['id'])) {
    header('Location: view.php');
    exit();
}

$id = (int)$_GET['id'];
$product = $conn->query("SELECT * FROM Products WHERE PCode = $id")->fetch_assoc();

if (!$product) {
    header('Location: view.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pname = sanitizeInput($conn, $_POST['pname']); // Now this will work
    
    $sql = "UPDATE Products SET PName = ? WHERE PCode = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $pname, $id);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Product updated successfully!";
        header('Location: view.php');
        exit();
    } else {
        $error = "Error updating product: " . $conn->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/nav.php'; ?>
    
    <div class="container">
        <h1>Edit Product</h1>
        
        <?php 
        if (isset($_SESSION['success'])) {
            echo '<div class="alert alert-success">'.$_SESSION['success'].'</div>';
            unset($_SESSION['success']);
        }
        if (isset($error)) {
            echo '<div class="alert alert-danger">'.$error.'</div>';
        }
        ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="pname" value="<?= htmlspecialchars($product['PName']) ?>" required>
            </div>
            
            <button type="submit" class="btn">Update Product</button>
            <a href="view.php" class="btn">Cancel</a>
        </form>
    </div>
</body>
</html>