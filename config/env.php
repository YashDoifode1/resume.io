<?php
/**
 * Simple .env loader (no composer required)
 */

$envPath = dirname(__DIR__) . '/.env';

if (!file_exists($envPath)) {
    throw new Exception('.env file not found');
}

$lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($lines as $line) {
    if (str_starts_with(trim($line), '#')) {
        continue;
    }

    [$key, $value] = array_pad(explode('=', $line, 2), 2, null);

    $key = trim($key);
    $value = trim($value, " \t\n\r\0\x0B\"");

    $_ENV[$key] = $value;
    putenv("$key=$value");
}

/**
 * Helper function
 */
function env($key, $default = null)
{
    return $_ENV[$key] ?? getenv($key) ?? $default;
}
