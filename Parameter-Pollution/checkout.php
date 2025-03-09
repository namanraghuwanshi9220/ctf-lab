<?php
// Retrieve all parameters
$price = $_GET['price'];
$discount = $_GET['discount'] ?? 0;
$tax = $_GET['tax'] ?? 0;

// Apply last-value logic for price
if (is_array($price)) {
    $price = end($price);  // Last price wins
}

// Apply first-value logic for discount
if (is_array($discount)) {
    $discount = reset($discount);  // First discount wins
}

// Apply last-value logic for tax
if (is_array($tax)) {
    $tax = end($tax);  // Last tax wins
}

// Ensure numeric values
$price = floatval($price);
$discount = floatval($discount);
$tax = floatval($tax);

// 🧮 Total calculation
$total = $price - $discount + $tax;

// Debug output (optional, can be removed)
echo "<pre>🛒 Checkout Summary:</pre>";
echo "<pre>💰 Price: {$price} Credits</pre>";
echo "<pre>🎁 Discount: {$discount} Credits</pre>";
echo "<pre>💸 Tax: {$tax} Credits</pre>";
echo "<pre>📊 Final Total: {$total} Credits</pre>";

// Win condition
if ($total == 1) {
    echo "<pre>🏴 flag{w0p8k5t1m3r7q4z}</pre>";
} else {
    echo "<pre>❌ You need to pay exactly 1 credit for the flag.</pre>";
}
?>
