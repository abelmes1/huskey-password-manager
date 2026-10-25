<?php
/**
 * Centralized security logging component.
 * Included by pages that need to record security events
 * (failed logins, vault creation/deletion, logout).
 *
 * The Loggly token is read from the environment (.env loaded into the
 * PHP Docker container), so the secret never appears in source code.
 */

require __DIR__ . '/../../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\LogglyHandler;

$logglyToken = $_ENV["LOGGLY_TOKEN"];

$logger = new Logger('Password Manager');
$logger->pushHandler(new LogglyHandler($logglyToken . '/tag/monolog', Logger::INFO));
