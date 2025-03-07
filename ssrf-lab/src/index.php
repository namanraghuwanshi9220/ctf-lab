<?php
function getHint($url) {
    $hints = [
        'localhost:' => "Internal services detected. Some routes like /internal/ might exist.",
        'localhost' => "You're getting warmer. What's hiding on port 80?",
        '127.0.0.1' => "127 reasons to keep going. Try specific paths.",
        '169.254.169.254' => "Trying cloud metadata? Maybe it's local-only.",
        '/internal/flag' => "Shhh! Almost there... Are you authorized?",
        'etc/passwd' => "Files are fun, but flags aren't always stored there.",
        'gopher://' => "Wow, getting fancy! Gopher might dig up secrets.",
        '/admin' => "Admins know things, but maybe it's deeper.",
        '0.0.0.0' => "Nice thinking, but does 0.0.0.0 have the answers?",
        '[::1]' => "IPv6 localhost detected. Try paths like /internal/.",
        'internal-api' => "Internal APIs love to hide secrets. Good thinking.",
        'ftp://' => "FTP? Hmm, old school. Think internal HTTP paths.",
        'file://' => "Careful! File reads can be dangerous, but is the flag a file?",
        'http://0/' => "Cheeky! 0 resolves locally. Try directories.",
        '@localhost' => "Bypass attempt detected! Keep trying creative tricks.",
        '127.1' => "Shortcuts to localhost work. Now try hitting /internal/.",
        '2130706433' => "Decimal IP for localhost? Smart. Look for internal paths.",
        'http://[::ffff:127.0.0.1]' => "IPv6-mapped IPv4 localhost. You're clever.",
        'whoami' => "Commands won't work here, but internal paths might.",
        'http://localhost/private/' => "Private area? Sounds promising...",
        'http://internal/' => "Internal domain... explore its structure.",
        '/flag' => "Flags are everywhere. Maybe combine with internal paths.",
        '/hidden/flag' => "So close. Try internal paths with 'flag'.",
        'http://localhost:8000' => "Alternate port detected. Is something running?",
        'http://127.0.0.1:5000' => "Different port? Maybe an internal service.",
        '/secrets/' => "Secrets folder? Maybe there's a flag inside.",
        '/.env' => ".env files leak secrets, but is the flag there?",
        '/config' => "Config files are goldmines, but keep digging.",
        '/debug' => "Debug endpoints sometimes leak flags. Try it.",
    ];

    foreach ($hints as $needle => $hint) {
        if (stripos($url, $needle) !== false) {
            return $hint;
        }
    }
    return "Keep trying... explore internal services and paths.";
}


$flag = file_get_contents('internal/flag.txt');

if (isset($_GET['url'])) {
    $url = $_GET['url'];
    $response = @file_get_contents($url);

    $hint = getHint($url);

    if (strpos($url, '/internal/flag') !== false) {
        $response = $flag;
    }
} else {
    $url = '';
    $response = '';
    $hint = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SSRF Lab</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
    <h1 class="text-3xl font-bold mb-6 text-center">🔥 SSRF Lab 🔥</h1>
    <form method="GET">
      <label class="block mb-2 text-sm font-medium text-gray-700">Enter URL to fetch:</label>
      <input type="text" name="url" placeholder="http://example.com" value="<?= htmlspecialchars($url) ?>" class="border border-gray-300 p-2 w-full rounded mb-4">
      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Fetch</button>
    </form>

    <?php if ($url): ?>
      <div class="mt-6">
        <h2 class="text-xl font-semibold">🔍 Response:</h2>
        <pre class="bg-gray-200 p-4 mt-2 rounded overflow-x-auto"><?= htmlspecialchars($response) ?></pre>
        <div class="mt-4 text-sm text-gray-600">
          💡 <strong>Hint:</strong> <?= $hint ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
