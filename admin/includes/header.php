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

<header class="navbar navbar-dark sticky-top bg-dark shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 p-4" href="dashboard.php">FLD Admin</a>
    <div class="navbar-nav">
        <div class="nav-item text-nowrap">
            <a class="btn btn-danger mx-2" href="../logout.php">
                <i class="fas fa-sign-out-alt me-1"></i> Se déconnecter
            </a>
        </div>
    </div>
</header>
