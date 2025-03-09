<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XSS Lab</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white flex items-center justify-center h-screen">
    <div class="bg-gray-800 p-6 rounded-lg shadow-lg w-96 text-center">
        <h1 class="text-2xl font-bold mb-4">XSS Lab</h1>
        <form method="GET">
            <input type="text" name="input" class="w-full p-2 mb-4 border border-gray-600 bg-gray-700 text-white rounded-lg" placeholder="Enter your payload">
            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-lg">Submit</button>
        </form>
        
        <div class="mt-4 p-3 bg-gray-700 rounded-lg">
            <p>Response:</p>
            <div class="text-yellow-400 text-lg">
                <?php
                if (isset($_GET['input'])) {
                    $payload = $_GET['input'];
                    echo $payload; // **Vulnerable to Reflected XSS**
                    
                    // **Flag Reveal Condition**
                    if (strpos($payload, '<script>alert("XSS")</script>') !== false) {
                        echo "<p class='text-green-400 font-bold mt-2'>Flag: FLAG{XSS_PWNED}</p>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
