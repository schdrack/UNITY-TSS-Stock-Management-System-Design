
<?php
session_start();
require_once '../includes/auth.php';

// If already logged in, redirect to dashboard
redirectIfLoggedIn();

// ... rest of your existing login code ...
?>

<?php

require_once '../config/db.php';
// require_once '../includes/auth.php';
require_once '../includes/auth.php';

if (isLoggedIn()) {
    header('Location: ../pages/dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM Users WHERE UserName = '$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['Password'])) {
            $_SESSION['user_id'] = $user['UserId'];
            $_SESSION['username'] = $user['UserName'];
            header('Location: ../pages/dashboard.php');
            exit();
        }
    }
    $error = "Invalid username or password";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>UNITY TSS - Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <h1>UNITY TSS Stock Management</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Login</button>
            <a href="register.php" class='btn'>Register</a>
            <a href="forgot-password.php" >Forgot Password</a>
           
        </form>
    </div>
</body>
</html>