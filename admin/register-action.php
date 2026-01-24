<?php
require_once "../config/constants.php";

// Extra safety
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Registration switch
if (!ADMIN_REGISTRATION_ENABLED) {
    die("Registration disabled.");
}

// CSRF CHECK (NO FAILURES)
$sessionToken = $_SESSION['csrf_token'] ?? '';
$postToken    = $_POST['csrf_token'] ?? '';

if ($sessionToken === '' || $postToken === '' || !hash_equals($sessionToken, $postToken)) {
    die("Invalid CSRF token");
}

// Collect input safely
$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm  = $_POST['confirm_password'] ?? '';

// Validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: register.php?error=Invalid email");
    exit;
}

if ($password !== $confirm) {
    header("Location: register.php?error=Passwords do not match");
    exit;
}

if (strlen($password) < 8) {
    header("Location: register.php?error=Password must be at least 8 characters");
    exit;
}

// Check existing admin
$stmt = mysqli_prepare($conn, "SELECT id FROM admins WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    header("Location: register.php?error=Admin already exists");
    exit;
}

// Insert admin
$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO admins (email, password) VALUES (?, ?)"
);
mysqli_stmt_bind_param($stmt, "ss", $email, $hash);

if (mysqli_stmt_execute($stmt)) {
    // Invalidate token after success
    unset($_SESSION['csrf_token']);

    header("Location: register.php?success=1");
    exit;
}

header("Location: register.php?error=Registration failed");
exit;
