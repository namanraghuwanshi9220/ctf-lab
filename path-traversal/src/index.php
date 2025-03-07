<?php
function getHint($file) {
    $hints = [
        '../../secrets/flag.txt' => "🎉 Congratulations! You've found the treasure.",
        '../' => "🔎 Trying to peek outside? Interesting...",
        '../../' => "🔍 Root directory? Going deeper...",
        '../../../' => "😲 Wow, you really want out of here.",
        '../../../../' => "🧭 Exploring the entire system?",
        '../secrets/' => "🗝️ Secrets are near. Keep going.",
        '../../secrets/' => "🗝️🗝️ Almost at the vault.",
        '../readme.txt' => "📄 Accessing upper-level files now.",
        '../note.txt' => "📝 Upper-level note found. Good thinking!",
        '../.env' => "🔐 Found environment secrets! Nice work.",
        '.env' => "🧐 Looking for environment secrets?",
        'note.txt' => "📝 Dev notes often leak good stuff.",
        '..%2F' => "🧠 URL-encoded traversal attempt detected.",
        '..%5C' => "🧠 Windows-style encoding? Clever.",
        '%252e%252e%252f' => "🎭 Double-encoded traversal. Nice trick.",
        '..%c0%af' => "🎭 Unicode slash detected!",
        '..%ef%bc%8f' => "🎭 Fullwidth slash spotted.",
        '..;/..;/secrets/flag.txt' => "🎯 Obfuscated attempt. Sharp move.",
        '....//....//' => "🔄 Recursive traversal, huh?",
        '.././.././' => "🔄 Mixing traversal styles. Nice.",
        '..%2f..%2f..%2f' => "🛠️ Classic encoded traversal.",
        '..\\..\\..\\' => "🛠️ Windows traversal in action.",
    ];

    foreach ($hints as $needle => $hint) {
        if (stripos($file, $needle) !== false) {
            return $hint;
        }
    }
    return "💡 Maybe try escaping the current directory...";
}

$flag = file_get_contents(__DIR__ . '/secrets/flag.txt');

if (isset($_GET['file']) && $_GET['file'] !== '') {
    $file = $_GET['file'];
    $hint = getHint($file);

    // Resolve traversal paths
    $basePath = realpath(__DIR__);
    $requestedPath = realpath($basePath . '/files/' . $file);

    // Handle traversal if realpath resolves the file
    if (!$requestedPath && file_exists(__DIR__ . '/' . $file)) {
        $requestedPath = realpath(__DIR__ . '/' . $file);
    }

    if ($file === '../../secrets/flag.txt' && file_exists(__DIR__ . '/secrets/flag.txt')) {
        $response = $flag;

    } elseif ($requestedPath && is_file($requestedPath)) {
        $response = file_get_contents($requestedPath);

    } elseif ($file === '../') {
        $response = "📁 Directory Listing:\n- readme.txt\n- note.txt\n- .env";

    } elseif ($file === '../../') {
        $response = "📁 Root Directory Listing:\n- files/\n- secrets/\n- index.php";

    } elseif ($file === '../secrets/' || $file === '../../secrets/') {
        $response = "📁 Secrets Directory Listing:\n- flag.txt";

    } else {
        $response = "❌ File not found or access denied.";
    }
} else {
    $file = '';
    $response = "ℹ️ Enter a file name to view its content.";
    $hint = "💡 Try viewing '.env', 'note.txt', or explore with '../'.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>🕵️ Path Traversal CTF</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen">
  <div class="bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-lg">
    <h1 class="text-3xl font-bold mb-6 text-center">🕵️ Path Traversal CTF 🕵️</h1>
    <p class="text-sm text-gray-400 mb-4">
      Recover the hidden flag by escaping the file viewer.
    </p>
    <form method="GET">
      <label class="block mb-2 text-sm">Enter filename:</label>
      <input type="text" name="file" placeholder="" value="<?= htmlspecialchars($file) ?>" class="border border-gray-700 bg-gray-900 p-2 w-full rounded mb-4 text-white">
      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Read File</button>
    </form>

    <?php if ($file): ?>
      <div class="mt-6">
        <h2 class="text-xl font-semibold">📄 File Contents:</h2>
        <pre class="bg-gray-700 p-4 mt-2 rounded overflow-x-auto"><?= htmlspecialchars($response) ?></pre>
        <div class="mt-4 text-sm text-gray-400">
          💡 <strong>Hint:</strong> <?= $hint ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
