<?php
/**
 * Logout after the move from client-side cookies to server-side sessions.
 * Before the fix, logout expired the 'authenticated' and
 * 'isSiteAdministrator' cookies, which users could forge.
 */

include './components/loggly-logger.php';
$logger->info('User logged out successfully');

// Clear the authenticated user from the server-side session
unset($_SESSION['authenticated']);

// Clear the administrator flag from the server-side session
unset($_SESSION['isSiteAdministrator']);

// Redirect to the login page
header('Location: /login.php');
exit();
