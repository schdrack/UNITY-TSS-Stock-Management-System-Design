<?php
// includes/functions.php
function sanitizeInput($conn, $input) {
    if (is_array($input)) {
        return array_map(function($item) use ($conn) {
            return $conn->real_escape_string(htmlspecialchars(trim($item)));
        }, $input);
    }
    return $conn->real_escape_string(htmlspecialchars(trim($input)));
}
function displayError($message) {
    echo '<div class="alert alert-danger">' . $message . '</div>';
}

function displaySuccess($message) {
    echo '<div class="alert alert-success">' . $message . '</div>';
}

?>