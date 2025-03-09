<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>🛒 Discount Disaster</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="assets/cart.js"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center">
    <div class="bg-gray-800 p-8 rounded shadow-md w-full max-w-md">
        <h1 class="text-3xl font-bold mb-6">🛒 Buy the Flag</h1>
        <p>Total Price: <span id="total">500</span> credits</p>
        <input id="coupon" placeholder="Enter coupon code"
            class="w-full mt-4 p-3 rounded bg-gray-700 text-white">
        <button onclick="applyCoupon()"
            class="mt-4 w-full py-2 bg-blue-600 hover:bg-blue-700 rounded">Apply Coupon</button>
        <button onclick="purchase()"
            class="mt-4 w-full py-2 bg-green-600 hover:bg-green-700 rounded">Purchase</button>
        <div id="response" class="mt-4"></div>
    </div>
  <!--
        🕵️ Pssst... Found the source, huh?
        💡 Coupons you might try:
        - DISCOUNT50
        - SUPERSECRET100 (might need special headers)
        - BACKDOOR999 (shhh... secret access)
    -->

</body>
</html>
