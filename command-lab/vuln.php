<?php
session_start();

// Initialize current directory in session
if (!isset($_SESSION['current_dir'])) {
    $_SESSION['current_dir'] = '/var/www';
}

// Path to the real flag
define('REAL_FLAG_PATH', '/var/www/private/flag.txt');

// Fake file list for root
$fake_root_files = ['index.php', 'flag.txt'];

// Payload-to-hint mapping
$hints = [
       "ping" => "Hint 🛠️: Ping is useful, but try to chain it with other commands using `;` or `&&`.",
    "ls" => "Hint 📂: Listing files? Maybe think about important files to target.",
    "whoami" => "Hint 👤: Knowing the user is cool, but can you read files?",
    "pwd" => "Hint 🧭: The current directory matters. What files live here?",
    "id" => "Hint 🆔: User IDs are nice, but look for flags!",
    "sleep" => "Hint ⏳: Sleeping on it? Maybe time-based attacks work.",
    "echo" => "Hint 📣: Echo can help craft payloads. Can you inject with it?",
    "curl" => "Hint 🌐: Curl can exfiltrate data. Dangerous stuff.",
    "wget" => "Hint 📥: Wget is cool, but exfiltration is blocked!",
    "tail" => "Hint 🏁: Almost there... but think differently.",
    "head" => "Hint 🎩: The start matters, but don't lose the end.",
    "uname" => "Hint 💻: System info is helpful, but flags are better.",
    "ps" => "Hint 🧠: Process listing might expose clues.",
    "top" => "Hint 🔝: Checking the top processes?",
    "who" => "Hint 👥: Other users might know secrets.",
    "netstat" => "Hint 🌐: Networking reveals paths.",
    "history" => "Hint 📜: Old commands can help.",
    "ifconfig" => "Hint 🌍: Looking at network configs?",
    "more" => "Hint 🔎: Reading files? Be careful."
];

// Track shown hints
if (!isset($_SESSION['shown_hints'])) {
    $_SESSION['shown_hints'] = [];
}

$ip = $_GET["ip"] ?? $_POST["ip"] ?? null;

if ($ip) {
    // Block dangerous patterns
    $blocked_patterns = [
        "cat",
        "more",
        "less",
        "tail",
        "curl",
        "wget",
        "http://",
         "https://"
     ];

    foreach ($blocked_patterns as $pattern) {
        if (stripos($ip, $pattern) !== false) {
            die("🚫 Command '$pattern' is blocked. Try another way!");
        }
    }

    // Show hints
    foreach ($hints as $keyword => $hint) {
        if (stripos($ip, $keyword) !== false && !in_array($keyword, $_SESSION['shown_hints'])) {
            echo "<div style='padding:10px; background-color:#D1FAE5; color:#065F46; margin-top:20px; border-radius:5px;'>
                $hint
                </div>";
            $_SESSION['shown_hints'][] = $keyword;
        }
    }

    $output = "";

    // Handle 'cd'
    if (preg_match('/^\s*cd\s*$/', $ip)) {
        $_SESSION['current_dir'] = '/var/www';
        $output = "Changed to default directory.";
    } elseif (preg_match('/^\s*cd\s+([^\s;]+)\s*$/', $ip, $matches)) {
        $new_dir = realpath($_SESSION['current_dir'] . '/' . $matches[1]);
        if ($new_dir && is_dir($new_dir) && strpos($new_dir, '/var/www') === 0) {
            $_SESSION['current_dir'] = $new_dir;
            $output = "Changed directory to $new_dir";
        } else {
            $output = "Invalid directory.";
        }
    }
    // Handle 'ls'
    elseif (preg_match('/^\s*ls\s*$/', $ip)) {
        if ($_SESSION['current_dir'] === '/var/www') {
            $output = implode("\n", $fake_root_files);
        } else {
            $cmd = 'ls ' . escapeshellarg($_SESSION['current_dir']);
            $output = shell_exec($cmd);
        }
    }
    // Handle 'awk' reading the fake flag.txt
    elseif (preg_match('/awk\s+[^\s]*\s+flag\.txt/', $ip)) {
        if ($_SESSION['current_dir'] === '/var/www') {
            $output = file_get_contents(REAL_FLAG_PATH);
        } else {
            $cmd = 'cd ' . escapeshellarg($_SESSION['current_dir']) . ' && ' . $ip;
            $output = shell_exec($cmd);
        }
    }
    // Other commands
    else {
        $cmd = 'cd ' . escapeshellarg($_SESSION['current_dir']) . ' && ' . $ip;
        $output = shell_exec($cmd);
    }

    echo "<pre>$output</pre>";
}
?>
