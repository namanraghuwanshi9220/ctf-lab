<?php
session_start();

if (!isset($_SESSION['total'])) {
    $_SESSION['total'] = 500;
}

if ($_SESSION['total'] === 0) {
    echo "🏴 flag{p7w9l4f5x3e0r2k}";
} else {
    echo "❌ You still owe {$_SESSION['total']} credits.";
}
?>
