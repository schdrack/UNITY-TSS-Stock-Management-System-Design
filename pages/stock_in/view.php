<?php
require_once '../../config/db.php';
require_once '../../includes/auth.php';

redirectIfNotLoggedIn();

$sql = "SELECT pi.*, p.PName 
        FROM ProductIn pi
        JOIN Products p ON pi.PCode = p.PCode
        ORDER BY pi.prIn_Date DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Stock In Records</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../includes/nav.php'; ?>
    
    <div class="container">
        <h1>Stock In Records</h1>
        <a href="add.php" class="btn">Add New Stock In</a>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['prIn_Date'] ?></td>
                        <td><?= $row['PName'] ?></td>
                        <td><?= $row['prIn_Quantity'] ?></td>
                        <td><?= number_format($row['prIn_Unit_Price'], 2) ?></td>
                        <td><?= number_format($row['prIn_TotalPrice'], 2) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['ProductIn_id'] ?>" class="btn">Edit</a>
                            <a href="delete.php?id=<?= $row['ProductIn_id'] ?>" class="btn btn-danger" 
                               onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No stock in records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>