async function applyCoupon() {
    const coupon = document.getElementById('coupon').value;
    const res = await fetch('/apply-coupon.php', {
        method: 'POST',
        headers: { 
            'Content-Type': 'application/json',
            'X-Client': 'frontend'
        },
        body: JSON.stringify({ coupon })
    });
    const data = await res.text();
    document.getElementById('response').innerText = data;
}

async function purchase() {
    const res = await fetch('/purchase.php');
    const data = await res.text();
    document.getElementById('response').innerText = data;
}

// 🕵️ Secret hint:
// const hiddenCoupon = atob('U1VQRVJTRUNSRVQxMDA=');
