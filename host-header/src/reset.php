<?php
// Ensure session is started only if needed
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_GET['token'])) {
    die('❌ Invalid reset link.');
}

$token = $_GET['token'];

// Validate token and host header condition
if (
    isset($_SESSION['leaked_token'], $_SESSION['leaked_host']) &&
    $_SESSION['leaked_token'] === $token &&
    $_SESSION['leaked_host'] === 'evil.com'
) {
    echo "<pre>🏴 FLAG{host_successfully_Ghost}</pre>";
    session_unset(); // Invalidate session after successful flag retrieval
    session_destroy();
} else {
    echo "<pre>❌ Invalid or unauthorized reset attempt.</pre>";
}
?>
