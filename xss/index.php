<?php
$flag = "FLAG{XSS_WORKS_FINE}";
$input = isset($_GET['q']) ? $_GET['q'] : '';
$hint = '';

$payloads = [
    '<script>alert(1)</script>' => 'Nice start! Replace alert with <code>showFlag()</code>.',
    '<svg onload=alert(1)>' => 'Great! Now trigger <code>showFlag()</code>.',
    '<img src=x onerror=alert(1)>' => 'Perfect! Swap alert with <code>showFlag()</code>.',
];

foreach ($payloads as $payload => $clue) {
    if (stripos($input, $payload) !== false) {
        $hint = $clue;
        break;
    }
}

// Flag is kept encoded to avoid leaking in View Source
$encodedFlag = base64_encode($flag);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reflected XSS Lab 🚀</title>
    <script>
        function showFlag() {
            const encoded = "<?php echo $encodedFlag; ?>";
            const flag = atob(encoded); // Decode base64
            document.getElementById('flag').innerText = flag;
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-4">Reflected XSS Lab 🧪</h1>
        <form method="GET" class="mb-4">
            <input
                type="text"
                name="q"
                placeholder="Enter your payload..."
                class="border p-2 w-full mb-2"
            />
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                Submit
            </button>
        </form>

        <?php if ($hint): ?>
            <div class="mb-4 p-4 bg-yellow-100 text-yellow-800 border border-yellow-300 rounded">
                <strong>Hint:</strong> <?php echo $hint; ?>
            </div>
        <?php endif; ?>

        <div class="p-4 bg-gray-50 border rounded">
            <h2 class="font-semibold mb-2">Your Input:</h2>
            <div>
                <?php
                // 🔥 Reflect input as raw (XSS vulnerable!)
                echo $input;
                ?>
            </div>
        </div>

        <div id="flag" class="mt-4 p-4 bg-green-100 text-green-700 font-bold rounded"></div>
    </div>
</body>
</html>
