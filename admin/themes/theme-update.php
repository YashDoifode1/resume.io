<?php
require_once __DIR__ . '/../../config/path.php';
require_once BASE_PATH . '/config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: themes.php');
    exit;
}

$id          = (int)$_POST['id'];
$name        = trim($_POST['name']);
$slug        = trim($_POST['slug']);
$theme_key   = trim($_POST['theme_key']);
$description = trim($_POST['description']);
$icon        = trim($_POST['icon']);
$is_premium  = isset($_POST['is_premium']) ? 1 : 0;

$stmt = $pdo->prepare("
    UPDATE themes SET
        name = ?,
        slug = ?,
        theme_key = ?,
        description = ?,
        icon = ?,
        is_premium = ?
    WHERE id = ?
");

$stmt->execute([
    $name,
    $slug,
    $theme_key,
    $description,
    $icon,
    $is_premium,
    $id
]);

header('Location: themes.php');
exit;
