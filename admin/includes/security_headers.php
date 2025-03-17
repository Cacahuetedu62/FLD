<?php
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: no-referrer");
header("Permissions-Policy: camera=(), microphone=()");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload"); // Force HTTPS
header("Content-Security-Policy: default-src 'self'; 
    script-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net;
    style-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net;
    font-src 'self' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net;
    img-src 'self' data:;
");
?>