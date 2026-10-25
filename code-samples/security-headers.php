<?php
/**
 * Security headers added at the top of login.php, before session_start().
 */

// Stop browsers from MIME-sniffing responses away from the declared type
header('X-Content-Type-Options: nosniff');

// Force HTTPS for one year, including subdomains (HSTS)
header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');

// Only load scripts, styles, and other content from the same origin (blocks most XSS)
header("Content-Security-Policy: default-src 'self';");

session_start();
