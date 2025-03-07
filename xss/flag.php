<?php
session_start(); // ✅ Start session correctly

header('Content-Type: text/plain'); // ✅ Prevent unwanted HTML rendering

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_SESSION['flag'])) {
        echo $_SESSION['flag']; // ✅ Flag is only sent via AJAX
    } else {
        echo "No flag found!";
    }
}
?>
