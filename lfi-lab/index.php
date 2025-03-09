<?php

error_reporting(0);

$flag = "flag{m4z0w5p7t1r6k3f}";

// 20 Common LFI Payloads & Hints
$hints = [
    "etc/passwd" => "🕵️ Try adding a null-byte `%00` to bypass restrictions!",
    "proc/self/environ" => "🔍 Environment variables might reveal session paths!",
    "proc/self/fd/2" => "💡 File descriptors can expose log files!",
    "php://filter/convert.base64-encode/resource=index.php" => "🛠 Base64 encoding can help read files!",
    "php://input" => "📥 Some web apps allow reading requests via `php://input`!",
    "php://expect" => "🖥 Sometimes `php://expect` lets you execute commands!",
    "php://temp" => "🔬 Temporary storage might hold useful content!",
    "php://memory" => "🧠 You can read stored input with `php://memory`!",
    "data://text/plain;base64," => "📜 You can inject and read base64 encoded data!",
    "filter=convert.iconv.utf-8.utf-7" => "🕵️ UTF-7 encoding can bypass some filters!",
    "../../../../../etc/passwd" => "🔓 Relative path traversal can be used to read files!",
    "../../../../../windows/win.ini" => "🖥 Windows config files might be helpful!",
    "../../../../../var/log/apache2/access.log" => "📖 Apache logs might reveal info!",
    "../../../../../usr/local/apache/logs/error_log" => "💬 Webserver logs might have hints!",
    "../../../../../var/log/nginx/access.log" => "📑 Nginx logs are sometimes readable!",
    "../../../../../var/lib/php/sessions" => "🔑 PHP session files might contain sensitive data!",
    "../../../../../home/user/.bash_history" => "⌨️ Bash history might expose commands!",
    "../../../../../root/.ssh/id_rsa" => "🔑 SSH private keys can be valuable!",
    "../../../../../proc/version" => "🔍 Kernel version info might be useful!",
    "../../../../../boot.ini" => "🖥 Windows boot settings might reveal something!"
];

$result = "";
$hintMessage = "";

// Check if 'file' parameter is set
if (isset($_GET['file'])) {
    $file = $_GET['file'];

    // Block direct access to the flag
    if ($file === "flag.txt") {
        $result = "🚫 You cannot access this file directly!";
    }
    // Encode index.php in Base64 if requested
    elseif ($file === "php://filter/convert.base64-encode/resource=index.php") {
        $content = file_get_contents("index.php");
        $base64Content = base64_encode($content);
        $result = "<b>Base64 Encoded Content:</b><br>
                   <div class='relative'>
                       <textarea id='base64Output' class='w-full p-2 border rounded bg-gray-200' readonly>$base64Content</textarea>
                       <button onclick='copyToClipboard()' class='absolute top-1 right-1 bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600'>📋 Copy</button>
                   </div>";
    }
    // If user tries to access `.env`, return a Base64-encoded flag
    elseif ($file === ".env") {
        $envContent = "SECRET_KEY=123456\nDB_PASSWORD=supersecret\nFLAG=" . $flag;
        $base64Env = base64_encode($envContent);
        $result = "<b>Base64 Encoded .env File:</b><br>
                   <div class='relative'>
                       <textarea id='envBase64Output' class='w-full p-2 border rounded bg-gray-200' readonly>$base64Env</textarea>
                       <button onclick='copyEnvToClipboard()' class='absolute top-1 right-1 bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600'>📋 Copy</button>
                   </div>";
    }
    // Check if input matches common LFI payloads & display hints
    elseif (array_key_exists($file, $hints)) {
        $hintMessage = "<b>Hint:</b> " . $hints[$file];
    }
    // Simulate LFI by reading files
    else {
        if (strpos($file, "../") !== false) {
            $result = "🚫 Directory traversal attempt blocked!";
        } else {
            $content = @file_get_contents($file);
            $result = !empty($content) ? "<pre class='overflow-auto max-h-60 p-2 border rounded bg-gray-100'>" . htmlspecialchars($content) . "</pre>" : "❌ File not found or empty!";
        }
    }

    // Show a random hint every time the button is clicked
    $randomHintKey = array_rand($hints);
    $randomHintMessage = "<b>Hint:</b> " . $hints[$randomHintKey];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔥 LFI Challenge</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-2xl">
        <h1 class="text-3xl font-bold text-center mb-6">🔥 LFI Challenge</h1>
        <p class="text-gray-600 text-center mb-6">
            Find a way to access the hidden flag by exploiting Local File Inclusion (LFI)!
        </p>

        <form method="GET" class="space-y-4">
            <input type="text" name="file" placeholder="Enter file path (e.g., pages/home.php)"
                class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            <button type="submit"
                class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Load File</button>
        </form>

        <?php if ($hintMessage): ?>
            <div class="mt-6 p-4 bg-yellow-100 border-l-4 border-yellow-500 rounded-lg">
                <h2 class="text-lg font-bold">🕵️ LFI Hint:</h2>
                <p><?= htmlspecialchars($hintMessage) ?></p>
            </div>
        <?php endif; ?>

        <?php if ($randomHintMessage): ?>
            <div class="mt-4 p-4 bg-green-100 border-l-4 border-green-500 rounded-lg">
                <h2 class="text-lg font-bold">🎯 Random Hint:</h2>
                <p><?= htmlspecialchars($randomHintMessage) ?></p>
            </div>
        <?php endif; ?>

        <?php if ($result): ?>
            <div class="mt-6 p-4 bg-gray-100 border rounded-lg">
                <h2 class="text-xl font-bold mb-2">📄 File Output:</h2>
                <div class="overflow-auto max-h-60 p-2 border rounded bg-gray-100">
                    <?= $result ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function copyToClipboard() {
            var textArea = document.getElementById("base64Output");
            textArea.select();
            document.execCommand("copy");
            alert("📋 Base64 copied to clipboard!");
        }
        function copyEnvToClipboard() {
            var textArea = document.getElementById("envBase64Output");
            textArea.select();
            document.execCommand("copy");
            alert("📋 .env Base64 copied to clipboard!");
        }
    </script>
</body>
</html>
