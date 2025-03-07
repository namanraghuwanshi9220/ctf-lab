<?php
$encodedSvgPayload = '%3Csvg+onload%3Dalert%281%29%3E';
$flag = base64_encode('FLAG{dom_xss_svg_encoded_master_2024}');

$payloadHint = '';
$showFlag = false;

if (isset($_GET['name']) || isset($_GET['message']) || isset($_GET['comment'])) {
    $input = $_GET['name'] ?? $_GET['message'] ?? $_GET['comment'];

    if ($input === '<svg onload=alert(1)>') {
        $payloadHint = "⚠️ Try encoding your payload with URL encoding.";
    } elseif ($input === $encodedSvgPayload) {
        $payloadHint = "🎉 Great! You found the correct encoded SVG payload. Here's your Base64 flag: $flag";
        $showFlag = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>💥 DOM-Based XSS Lab 💥</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen">

  <!-- 🕵️‍♂️ Hidden clues (check the source!) -->
  <!-- Try injecting SVG payloads like: <svg onload=alert(1)> -->
  <!-- URL encode your payloads to bypass filters -->
  <!-- Example encoded payload: %3Csvg+onload%3Dalert(1)%3E -->
  <!-- Flags are sometimes hidden in Base64... -->

  <div class="bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-lg text-center">
    <h1 class="text-3xl font-bold mb-6">💥 DOM-Based XSS CTF 💥</h1>
    <p class="text-sm text-gray-400 mb-4">
      Try injecting payloads into the parameters <code>?name=</code>, <code>?message=</code>, or <code>?comment=</code>.
    </p>

    <p class="text-xl mt-6">Hello, <span id="name">stranger</span>!</p>
    <p class="text-xl mt-6">Message: <span id="message">nothing here</span></p>
    <p class="text-xl mt-6">Comment: <span id="comment">no comment</span></p>

    <?php if ($payloadHint): ?>
    <div class="mt-6 text-sm text-green-400">
      💡 <strong>Hint:</strong> <?= $payloadHint ?>
    </div>
    <?php endif; ?>

  </div>

  <script>
    const params = new URLSearchParams(window.location.search);

    const nameParam = params.get('name');
    const messageParam = params.get('message');
    const commentParam = params.get('comment');

    if (nameParam) {
      document.getElementById('name').innerHTML = decodeURIComponent(nameParam); // ⚠️ Vulnerable spot
    }

    if (messageParam) {
      document.getElementById('message').innerHTML = decodeURIComponent(messageParam); // ⚠️ Vulnerable spot
    }

    if (commentParam) {
      document.getElementById('comment').innerHTML = decodeURIComponent(commentParam); // ⚠️ Vulnerable spot
    }
  </script>

</body>
</html>
