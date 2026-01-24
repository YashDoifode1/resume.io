<?php
require_once __DIR__ . '/../config/database.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit('Invalid request');
}

/* ==========================
   Validate Inputs
========================== */
$name        = trim($_POST['name']);
$key         = preg_replace('/[^a-z0-9_]/', '', strtolower($_POST['theme_key']));
$description = trim($_POST['description']);
$icon        = $_POST['icon'] ?: '🎨';
$isPremium   = isset($_POST['is_premium']) ? 1 : 0;

if (!$key || !$name) {
    exit('Missing fields');
}

/* ==========================
   Validate File
========================== */
if (!isset($_FILES['theme_file']) || $_FILES['theme_file']['error'] !== 0) {
    exit('File upload failed');
}

$ext = pathinfo($_FILES['theme_file']['name'], PATHINFO_EXTENSION);
if ($ext !== 'php') {
    exit('Only PHP theme files allowed');
}

/* ==========================
   Rename + Move File
========================== */
$newFileName = 'theme-' . $key . '.php';
$destination = __DIR__ . '/../themes/' . $newFileName;

if (!move_uploaded_file($_FILES['theme_file']['tmp_name'], $destination)) {
    exit('Failed to move theme file');
}

/* ==========================
   Insert DB
========================== */
$stmt = $pdo->prepare("
    INSERT INTO themes 
    (theme_key, name, description, icon, file_name, is_active, is_premium)
    VALUES (?, ?, ?, ?, ?, 1, ?)
");

$stmt->execute([
    $key,
    $name,
    $description,
    $icon,
    $newFileName,
    $isPremium
]);

header('Location: themes.php');
exit;
