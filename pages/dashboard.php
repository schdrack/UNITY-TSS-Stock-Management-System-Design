
<?php
require_once '../config/db.php';
require_once '../includes/auth.php';

// Start session and check login
startSecureSession();
redirectIfNotLoggedIn();

// ... rest of your dashboard code ...
?>

<?php
require_once '../config/db.php';
require_once '../includes/auth.php';

if (!isLoggedIn()) {
    header('Location: ../pages/login.php');
    exit();
}

$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>UNITY TSS - Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h1>Welcome, <?php echo $username; ?></h1>
            <nav>
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="products/add.php">Add Product</a></li>
                    <li><a href="products/view.php">View Products</a></li>
                    <li><a href="stock_in/add.php">Stock In</a></li>
                    <li><a href="stock_out/add.php">Stock Out</a></li>
                    <li><a href="reports/daily_report.php">Daily Report</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </header>
        
        <main>
            <div class="cards">
                <div class="card">
                    <h3>Total Products</h3>
                    <?php
                    $result = $conn->query("SELECT COUNT(*) FROM Products");
                    $count = $result->fetch_row()[0];
                    ?>
                    <p><?php echo $count; ?></p>
                </div>
                
                <div class="card">
                    <h3>Today's Stock In</h3>
                    <?php
                    $today = date('Y-m-d');
                    $result = $conn->query("SELECT COUNT(*) FROM ProductIn WHERE prIn_Date = '$today'");
                    $count = $result->fetch_row()[0];
                    ?>
                    <p><?php echo $count; ?></p>
                </div>
                
                <div class="card">
                    <h3>Today's Stock Out</h3>
                    <?php
                    $result = $conn->query("SELECT COUNT(*) FROM ProductOut WHERE prOut_Date = '$today'");
                    $count = $result->fetch_row()[0];
                    ?>
                    <p><?php echo $count; ?></p>
                </div>
            </div>
        </main>
    </div>
</body>
</html>