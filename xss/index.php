<?php
session_start(); // ✅ Start session at the very beginning

$_SESSION['flag'] = "FLAG{XSS_PASS_XY}"; // ✅ Store flag in session (backend only)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reflected XSS Lab</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex justify-center items-center h-screen bg-gray-100">

    <div class="bg-white p-6 rounded-lg shadow-lg text-center">
        <h2 class="text-2xl font-bold mb-4">Reflected XSS Challenge</h2>
        <p class="text-gray-500 mb-4">Find a way to trigger an alert box with the flag! 🚩</p>

        <form action="" method="GET">
            <input type="text" name="name" placeholder="Enter your name"
                class="border p-2 rounded-md w-full mb-3 focus:ring focus:ring-blue-300">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Submit</button>
        </form>

        <?php
            if (isset($_GET['name'])) {
                $name = $_GET['name']; // ❌ No sanitization = XSS vulnerable
                echo "<p class='mt-4 text-lg'>FLAG{You_Hit_the_web}, $name!</p>"; // 🛑 XSS executes here
            }
        ?>

        <script>
            function getFlag() {
                fetch('flag.php')
                .then(response => response.text())
                .then(flag => alert(flag)) // ✅ Flag is revealed only if XSS is executed
                .catch(error => console.error('Error:', error));
            }
        </script>
        
    </div>

</body>
</html>

