
<?php
// Enable ALL error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Database configuration
$host = 'localhost';
$user = 'root'; // Change if needed
$password = ''; // Change if needed
$database = 'STORE';

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define base URL
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/UNITY_TSS/'); // Adjust path as needed

// Test output (remove in production)
// echo "<!-- Database connection successful -->";
?>
<?php
// Enable full error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Rest of your db.php code...

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'STORE';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";

// Create tables if they don't exist
$sql = "CREATE TABLE IF NOT EXISTS Users (
    UserId INT AUTO_INCREMENT PRIMARY KEY,
    UserName VARCHAR(50) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL
)";

$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS Products (
    PCode INT AUTO_INCREMENT PRIMARY KEY,
    PName VARCHAR(100) NOT NULL
)";

$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS ProductIn (
    ProductIn_id INT AUTO_INCREMENT PRIMARY KEY,
    PCode INT NOT NULL,
    prIn_Date DATE NOT NULL,
    prIn_Quantity INT NOT NULL,
    prIn_Unit_Price DECIMAL(10,2) NOT NULL,
    prIn_TotalPrice DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (PCode) REFERENCES Products(PCode) ON DELETE CASCADE
)";

$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS ProductOut (
    ProductOut_id INT AUTO_INCREMENT PRIMARY KEY,
    PCode INT NOT NULL,
    prOut_Date DATE NOT NULL,
    prOut_Quantity INT NOT NULL,
    prOut_unit_Price DECIMAL(10,2) NOT NULL,
    prOut_TotalPrice DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (PCode) REFERENCES Products(PCode) ON DELETE CASCADE
)";

$conn->query($sql);

// Create default admin user if not exists
$result = $conn->query("SELECT COUNT(*) FROM Users");
if ($result->fetch_row()[0] == 0) {
    $username = "admin";
    $password = password_hash("admin123", PASSWORD_DEFAULT);
    $conn->query("INSERT INTO Users (UserName, Password) VALUES ('$username', '$password')");
}
?>