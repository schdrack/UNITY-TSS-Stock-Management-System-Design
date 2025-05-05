<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
function startSecureSession() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start([
            'cookie_lifetime' => 86400,
            'cookie_secure' => true,
            'cookie_httponly' => true,
            'use_strict_mode' => true
        ]);
    }
}

function isLoggedIn() {
    startSecureSession();
    return isset($_SESSION['user_id']);
}

function redirectIfNotLoggedIn($redirectPath = '../pages/login.php') {
    if (!isLoggedIn()) {
        header("Location: $redirectPath");
        exit();
    }
}

function redirectIfLoggedIn($redirectPath = '../pages/dashboard.php') {
    if (isLoggedIn()) {
        header("Location: $redirectPath");
        exit();
    }
}
?>