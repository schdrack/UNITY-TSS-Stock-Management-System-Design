<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/functions.php';

redirectIfNotLoggedIn();

$date_filter = isset($_GET['date']) ? $_GET['date'] : '';
$where_clause = $date_filter ? "WHERE po.prOut_Date = '$date_filter'" : '';

$sql = "SELECT po.*, p.PName 
        FROM ProductOut po
        JOIN Products p ON po.PCode = p.PCode
        $where_clause
        ORDER BY po.prOut_Date DESC, p.PName";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Stock Out Records - UNITY TSS</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php include __DIR__ . '/../../includes/nav.php'; ?>
    
    <div class="container">
        <h1>Stock Out Records</h1>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <div class="filter-section">
            <form method="GET" class="filter-form">
                <div class="form-group">
                    <label>Filter by Date:</label>
                    <input type="date" name="date" value="<?= $date_filter ?>">
                    <button type="submit" class="btn btn-primary">Apply Filter</button>
                    <?php if ($date_filter): ?>
                        <a href="view.php" class="btn btn-secondary">Clear Filter</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <div class="action-buttons">
            <a href="add.php" class="btn btn-success">
                <i class="fas fa-plus"></i> Add New Stock Out
            </a>
        </div>
        
        <div class="table-responsive">
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
                                <td><?= $row['prOut_Date'] ?></td>
                                <td><?= htmlspecialchars($row['PName']) ?></td>
                                <td><?= $row['prOut_Quantity'] ?></td>
                                <td><?= number_format($row['prOut_unit_Price'], 2) ?> RWF</td>
                                <td><?= number_format($row['prOut_TotalPrice'], 2) ?> RWF</td>
                                <td class="actions">
                                    <a href="edit.php?id=<?= $row['ProductOut_id'] ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="delete.php?id=<?= $row['ProductOut_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this record?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?><?php
// Absolute path requires
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/functions.php';

// Debug: Test if files were included
if (!function_exists('redirectIfNotLoggedIn')) {
    die("Error: Required functions not loaded. Check file paths.");
}

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Debug: Check session
if (!isset($_SESSION['user_id'])) {
    die("Session error: User not logged in. Check auth.php");
}

// Process date filter
$date_filter = isset($_GET['date']) ? $conn->real_escape_string($_GET['date']) : '';
$where_clause = $date_filter ? "WHERE po.prOut_Date = '$date_filter'" : '';

// Build and execute query
$sql = "SELECT po.*, p.PName 
        FROM ProductOut po
        JOIN Products p ON po.PCode = p.PCode
        $where_clause
        ORDER BY po.prOut_Date DESC";

$result = $conn->query($sql);

// Check query success
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stock Out Records</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
    <style>
        /* Basic table styles if CSS fails to load */
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
        .alert { padding: 10px; margin: 10px 0; border-radius: 4px; }
        .alert-success { background-color: #dff0d8; color: #3c763d; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Stock Out Records</h1>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        
        <form method="GET" class="filter-form">
            <label>Filter by Date: 
                <input type="date" name="date" value="<?php echo htmlspecialchars($date_filter); ?>">
            </label>
            <button type="submit">Filter</button>
            <?php if ($date_filter): ?>
                <a href="view.php">Clear Filter</a>
            <?php endif; ?>
        </form>
        
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['prOut_Date']); ?></td>
                        <td><?php echo htmlspecialchars($row['PName']); ?></td>
                        <td><?php echo htmlspecialchars($row['prOut_Quantity']); ?></td>
                        <td><?php echo number_format($row['prOut_unit_Price'], 2); ?></td>
                        <td><?php echo number_format($row['prOut_TotalPrice'], 2); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No records found<?php echo $date_filter ? " for $date_filter" : ''; ?></p>
        <?php endif; ?>
        
        <a href="add.php" class="button">Add New Stock Out</a>
    </div>
</body>
</html>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No stock out records found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>