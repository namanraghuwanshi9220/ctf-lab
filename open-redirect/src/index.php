<?php
function getHint($url) {
    $hints = [
        'https://google.com' => "🔍 Searching won't find the prize. Think like a winner.",
        'https://evil.com' => "😈 So close to being bad... but only winners get flags.",
        'https://admin.panel' => "🔐 Admins might hide secrets, but what's the winning domain?",
        'https://redirectme.com' => "🔁 Redirecting... but redirect where to win?",
        'https://bypass.local' => "🛠️ Bypassing is cool, but you want to win.",
        'https://payloads.online' => "💣 Payload loaded. Still no flag.",
        'https://localhost' => "🏠 You're staying too close to home.",
        'https://127.0.0.1' => "🌀 Looping in circles won't help.",
        'https://winner.ctf' => "🤔 Winner vibes... but is that the real domain?",
        'ctf' => "🧠 Hmmm... you're thinking like a CTF player.",
        'win' => "🏆 Winning thoughts detected...",
    ];

    foreach ($hints as $needle => $hint) {
        if (stripos($url, $needle) !== false) {
            return $hint;
        }
    }
    return "💡 Rumors say the flag hides on a domain meant to 'win' the CTF.";
}

if (isset($_GET['url']) && $_GET['url'] !== '') {
    $url = $_GET['url'];
    $hint = getHint($url);

    // ✅ Fake flags for tricking players
    if ($url === 'https://admin.panel') {
        header('Content-Type: text/plain');
        echo "FAKE_FLAG{admin_is_not_winning}";
        exit;
    }

    if ($url === 'https://evil.com') {
        header('Content-Type: text/plain');
        echo "FAKE_FLAG{evil_but_not_enough}";
        exit;
    }

    // ✅ Real flag
    if ($url === 'https://ctf-win.com') {
        header('Content-Type: text/plain');
        echo "flag{P9x!vG3#Tz6M@qK8}";
        exit;
    }

    // Normal redirect
    header("Location: $url");
    exit;
} else {
    $url = '';
    $hint = "💡 Try entering suspicious domains, but only one truly wins...";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>🌐 Open Redirect CTF Challenge</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen">
  <div class="bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-lg">
    <h1 class="text-3xl font-bold mb-6 text-center">🌐 Open Redirect CTF 🌐</h1>
    <p class="text-sm text-gray-400 mb-4">
      Escape through the right redirect and claim your flag.
    </p>
    <form method="GET">
      <label class="block mb-2 text-sm">Enter redirect URL:</label>
      <input type="text" name="url" placeholder="https://example.com" value="<?= htmlspecialchars($url) ?>" class="border border-gray-700 bg-gray-900 p-2 w-full rounded mb-4 text-white">
      <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">Redirect</button>
    </form>

    <?php if ($url): ?>
      <div class="mt-6 text-sm text-gray-400">
        💡 <strong>Hint:</strong> <?= $hint ?>
      </div>
    <?php endif; ?>

     <!-- 🔍 Hidden clue in the page source -->
  <!-- Maybe the key is hidden in these domains... -->
  <!-- https://evil.com -->
  <!-- https://google.com -->
  <!-- https://admin.panel -->
  <!-- https://redirectme.com -->
  <!-- https://ctf-win.com -->
  <!-- https://payloads.online -->
  <!-- https://bypass.local -->
  <!-- https://winner.ctf -->
  <!-- But only ONE can lead you to the real flag... -->
  </div>
</body>
</html>
