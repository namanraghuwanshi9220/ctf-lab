<?php
// Dashboard Page
$users = [
    1 => ['name' => 'Alice', 'email' => 'alice@example.com'],
    2 => ['name' => 'Bob', 'email' => 'bob@example.com'],
    3 => ['name' => 'Charlie', 'email' => 'charlie@example.com'],
    4 => ['name' => 'David', 'email' => 'david@example.com'],
    5 => ['name' => 'Eve', 'email' => 'eve@example.com'],
    6 => ['name' => 'Unknown', 'email' => 'hidden_user@ctf.com'] // Trickier flag location
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CTF IDOR Challenge</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-gray-900 to-gray-700 text-white">
    <div class="container mx-auto p-8 text-center">
        <h1 class="text-4xl font-bold mb-6">🕵️ IDOR Challenge</h1>
        <p class="text-lg text-gray-300 mb-6">Can you find something hidden in these profiles?</p>
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg inline-block">
            <ul class="text-left space-y-3">
                <?php foreach ($users as $id => $user): if ($id !== 6) { ?>
                    <li class="p-3 bg-gray-700 rounded-lg hover:bg-gray-600 transition">
                        <a href="profile.php?id=<?= $id ?>" class="text-blue-300 hover:underline">
                            View <?= $user['name'] ?>'s Profile
                        </a>
                    </li>
                <?php } endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>
