<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("HTTP/1.1 403 Forbidden");
    echo "Access Denied!";
    exit();
}

// Your CTF flag
$flag = "CTF{s_injection_d}";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏴‍☠️ Flag Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex justify-center items-center h-screen bg-gray-100">

    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md text-center">
        <h1 class="text-3xl font-bold text-green-600 mb-4">🎉 Congratulations!</h1>
        <p class="text-gray-700 text-lg mb-6">You have successfully logged in!</p>
        <div class="bg-gray-100 p-4 rounded-md border border-gray-300">
            <span class="block text-sm text-gray-500 mb-2">Your flag is:</span>
            <code class="text-xl font-mono text-blue-600"><?php echo $flag; ?></code>
        </div>
        <p class="mt-6 text-gray-400 text-sm">🚀 Now try to understand how the injection worked!</p>
    </div>

</body>
</html>
