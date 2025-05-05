<?php
// reports/daily_report.php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

// Start session and check login
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'pages/login.php');
    exit();
}

// Set default date to today
$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

// Get daily stock in report
$sql = "SELECT p.PName, pi.prIn_Quantity, pi.prIn_Unit_Price, pi.prIn_TotalPrice 
        FROM ProductIn pi
        JOIN Products p ON pi.PCode = p.PCode
        WHERE pi.prIn_Date = ?
        ORDER BY p.PName";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $date);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Stock Report - UNITY TSS</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/nav.php'; ?>
    
    <div class="container">
        <h1 class="report-title">Daily Stock Report</h1>
        
        <form method="GET" class="report-form">
            <div class="form-group">
                <label for="report-date">Select Date:</label>
                <input type="date" id="report-date" name="date" value="<?php echo $date; ?>" required>
                <button type="submit" class="btn btn-primary">Generate Report</button>
            </div>
        </form>
        
        <?php if (isset($_GET['date'])): ?>
            <h2 class="report-date">Report for: <?php echo $date; ?></h2>
            
            <?php if ($result->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Unit Price (RWF)</th>
                                <th>Total Price (RWF)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $grandTotal = 0;
                            while ($row = $result->fetch_assoc()): 
                                $grandTotal += $row['prIn_TotalPrice'];
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['PName']); ?></td>
                                    <td><?php echo number_format($row['prIn_Quantity']); ?></td>
                                    <td><?php echo number_format($row['prIn_Unit_Price'], 2); ?></td>
                                    <td><?php echo number_format($row['prIn_TotalPrice'], 2); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                        <tfoot>
                            <tr class="grand-total">
                                <td colspan="3"><strong>Grand Total</strong></td>
                                <td><strong><?php echo number_format($grandTotal, 2); ?> RWF</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div class="report-actions">
                    <button onclick="window.print()" class="btn btn-print">
                        <i class="fas fa-print"></i> Print Report
                    </button>
                    <a href="<?php echo BASE_URL; ?>reports/export_report.php?date=<?php echo $date; ?>" class="btn btn-export">
                        <i class="fas fa-file-excel"></i> Export to Excel
                    </a>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> No stock records found for <?php echo $date; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Print-specific styles -->
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .container, .container * {
                visibility: visible;
            }
            .container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .report-actions {
                display: none;
            }
        }
    </style>
</body>
</html>