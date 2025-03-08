<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center">
    <div class="bg-gray-800 p-8 rounded shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-4">🔑 Password Reset</h1>
        <form action="mailer.php" method="POST">
            <input type="email" name="email" placeholder="Enter your email"
                class="w-full p-3 rounded bg-gray-700 text-white">
            <button type="submit"
                class="mt-4 w-full py-2 bg-blue-600 hover:bg-blue-700 rounded">Send Reset Link</button>
        </form>
    </div>
</body>
</html>
