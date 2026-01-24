<?php
require_once "../config/constants.php";

// Ensure session
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// CSRF validation
$sessionToken = $_SESSION['csrf_token'] ?? '';
$postToken    = $_POST['csrf_token'] ?? '';

if ($sessionToken === '' || $postToken === '' || !hash_equals($sessionToken, $postToken)) {
    die("Invalid CSRF token");
}

// Collect input
$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Validate
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($password)) {
    header("Location: login.php?error=Invalid credentials");
    exit;
}

// Fetch admin
$stmt = mysqli_prepare(
    $conn,
    "SELECT id, password FROM admins WHERE email = ? LIMIT 1"
);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$admin = mysqli_fetch_assoc($result);

// Verify credentials
if (!$admin || !password_verify($password, $admin['password'])) {
    header("Location: login.php?error=Incorrect email or password");
    exit;
}

// Login success → regenerate session ID
session_regenerate_id(true);

// Store admin session
$_SESSION['admin_id'] = $admin['id'];
$_SESSION['admin_email'] = $email;

// Remove CSRF token after use
unset($_SESSION['csrf_token']);

header("Location: dashboard.php");
exit;
