<?php
require_once '../../config/db.php';
require_once '../../includes/auth.php';

redirectIfNotLoggedIn();

$sql = "SELECT * FROM Products ORDER BY PName";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Products</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body align="center">
    <?php include '../../includes/nav.php'; ?>
    
    <div class="container">
        <h1>Product List</h1>
        <a href="add.php" class="btn">Add New Product</a>
        
        <table class="data-table" align="center">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Product Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['PCode'] ?></td>
                        <td><?= $row['PName'] ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['PCode'] ?>" class="btn">Edit</a>
                            <a href="delete.php?id=<?= $row['PCode'] ?>" class="btn btn-danger" 
                               onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No products found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>