<?php
session_start();

// 🚨 Secure Route: Redirect if user is NOT logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: index.php"); 
    exit();
}

$flag = "flag{SQL_dhdh_kdsd}";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flag Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex justify-center items-center h-screen bg-green-100">

    <div class="bg-white p-8 rounded-lg shadow-lg text-center">
        <h2 class="text-2xl font-bold text-green-500 mb-4">Congratulations! 🎉</h2>
        <p class="text-lg">You have successfully exploited SQL Injection.</p>
        <p class="mt-4 text-xl font-bold text-red-500"><?php echo $flag; ?></p>
    </div>

</body>
</html>
