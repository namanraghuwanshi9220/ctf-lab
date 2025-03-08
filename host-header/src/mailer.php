<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    
    // Generate a new token and store it in the session
    $token = bin2hex(random_bytes(16));
    $_SESSION['leaked_token'] = $token;
    $_SESSION['leaked_host'] = $_SERVER['HTTP_HOST'];

    // Construct the reset link dynamically
    $reset_link = "http://{$_SESSION['leaked_host']}/reset.php?token={$token}";

    // List of hints (20 hints rotating on each request)
    $hints = [
        "💡 Headers can reveal valuable information.",
        "🔗 The reset link is generated dynamically.",
        "👀 Some clues are hidden in unexpected places.",
        "🧩 Modify headers to see different responses.",
        "🕵️ Think like a hacker, not a regular user.",
        "🚀 Try tools like Burp Suite for better insights.",
        "🔐 Reset links should never be exposed in logs!",
        "⚠️ Always check how user input is handled.",
        "🔄 Refreshing the page might change something.",
        "🤔 What if the page doesn’t display everything?",
        "🎯 Redirects can sometimes be useful.",
        "🔍 Developers often debug using console.log().",
        "📜 JavaScript can give you extra details.",
        "🎭 Can you trick the system into showing more?",
        "🧐 Ever heard of Host Header Injection?",
        "🛠️ Inspect the developer console (F12 → Console).",
        "🔄 Tokens should not be reused—how does this one behave?",
        "🌐 What does changing the Host header do?",
        "🔍 Read between the lines in source code.",
        "🛑 Not all vulnerabilities are visible at first glance."
    ];

    // Track hint number in session (loop through hints)
    if (!isset($_SESSION['hint_index'])) {
        $_SESSION['hint_index'] = 0;
    } else {
        $_SESSION['hint_index'] = ($_SESSION['hint_index'] + 1) % count($hints);
    }
    $current_hint = $hints[$_SESSION['hint_index']];

    // Display UI with Tailwind CSS
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <title>Password Reset</title>
        <script src='https://cdn.tailwindcss.com'></script>
    </head>
    <body class='bg-gray-900 text-white min-h-screen flex items-center justify-center'>
        <div class='bg-gray-800 p-8 rounded shadow-md w-full max-w-md'>
            <h1 class='text-2xl font-bold mb-4'>🔑 Password Reset</h1>
            <p class='mb-2'>✅ Password reset link sent to <span class='text-yellow-300'>{$email}</span>.</p>
            <p class='text-green-400'>Hint: <span class='text-yellow-300'>{$current_hint}</span></p>
            <button onclick='window.location.href=\"index.php\"'
                class='mt-4 w-full py-2 bg-blue-600 hover:bg-blue-700 rounded'>
                🔄 Reset Another Email
            </button>
        </div>
        <script>console.log('Leaked reset link: {$reset_link}');</script>
    </body>
    </html>";
} else {
    // If accessed directly, clear session and redirect
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit;
}
?>
