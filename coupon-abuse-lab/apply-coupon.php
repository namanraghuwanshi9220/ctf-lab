<?php
session_start();

if (!isset($_SESSION['total'])) {
    $_SESSION['total'] = 500;
}
if (!isset($_SESSION['coupons'])) {
    $_SESSION['coupons'] = [];
}

$body = json_decode(file_get_contents('php://input'), true);
if (!$body || !isset($body['coupon'])) {
    die('❌ Invalid request.');
}

$coupon = $body['coupon'];
$headers = getallheaders();
$clientHeader = $headers['X-Client'] ?? '';
$bypassHeader = $headers['X-Bypass'] ?? '';

if (in_array($coupon, $_SESSION['coupons'])) {
    die('❌ This coupon has already been used in this session.');
}

switch ($coupon) {
    case 'DISCOUNT50':
        if ($_SESSION['total'] > 50) {
            $_SESSION['total'] -= 50;
            $_SESSION['coupons'][] = $coupon;
            echo "✅ 50 credits off! Total is now {$_SESSION['total']} credits.";
        } else {
            echo "❌ DISCOUNT50 cannot lower total below 450 credits.";
        }
        break;

    case 'SUPERSECRET100':
        if ($clientHeader === 'frontend') {
            $_SESSION['total'] -= 100;
            $_SESSION['coupons'][] = $coupon;
            echo "✅ 100 credits off! Total is now {$_SESSION['total']} credits.";
        } else {
            echo '❌ Invalid client.';
        }
        break;

    case 'BACKDOOR999':
        if ($bypassHeader === 'true') {
            $_SESSION['total'] = 0;
            $_SESSION['coupons'][] = $coupon;
            echo "🎉 Backdoor activated! Total is now FREE.";
        } else {
            echo '❌ Access denied.';
        }
        break;

    default:
        echo '❌ Invalid coupon code.';
}
?>
