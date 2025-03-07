<?php
// Profile Page with IDOR Vulnerability
$users = [
    1 => ['name' => 'Alice', 'email' => 'alice@example.com'],
    2 => ['name' => 'Bob', 'email' => 'bob@example.com'],
    3 => ['name' => 'Charlie', 'email' => 'charlie@example.com'],
    4 => ['name' => 'David', 'email' => 'david@example.com'],
    5 => ['name' => 'Eve', 'email' => 'eve@example.com'],
    6 => ['name' => 'Unknown', 'email' => 'hidden_user@ctf.com', 'flag' => 'flag{hidden_idor_vulnerability_found}'] // Trickier flag
];

$id = $_GET['id'] ?? 1; // No authentication check (IDOR vulnerability)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
    <div class="container mx-auto p-8 text-center">
        <?php if (isset($users[$id])): ?>
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg inline-block">
                <h1 class="text-3xl font-bold">Profile of <?= $users[$id]['name'] ?></h1>
                <p class="text-lg text-gray-300 mt-3">Email: <?= $users[$id]['email'] ?></p>
                <?php if ($id == 6): ?>
                    <p class="text-green-400 mt-4 font-mono hidden" id="flag">FLAG: <?= $users[$id]['flag'] ?></p>
                    <button onclick="document.getElementById('flag').classList.remove('hidden')" class="mt-4 px-4 py-2 bg-blue-500 rounded hover:bg-blue-600 transition">Reveal Secret</button>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <h1 class="text-3xl font-bold">User not found</h1>
        <?php endif; ?>
    </div>
</body>
</html>
