<?php
// Only allow the flag if called via XMLHttpRequest (fetch, AJAX)
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    echo "flag{D9p!X3V#K7qT6@M}";
} else {
    http_response_code(403);
    echo "Forbidden!";
}
