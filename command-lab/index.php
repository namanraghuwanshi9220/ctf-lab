<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CTF: Command Injection</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex justify-center items-center h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-lg w-96 text-center">
        <h2 class="text-2xl font-bold mb-4"></h2>
        <p class="text-gray-500 mb-4">Ping an IP address.</p>

        <form method="POST" action="vuln.php" class="space-y-4">
            <input type="text" name="ip" class="border p-2 w-full rounded-md focus:ring focus:ring-blue-300" placeholder="Enter IP address">
            
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md w-full hover:bg-red-600">
                Submit
            </button>
        </form>
    </div>
</body>
</html>
