<?php
require_once __DIR__ . '/../config/database.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$id = (int)($_POST['id'] ?? 0);

$stmt = $pdo->prepare("
    UPDATE themes 
    SET is_active = IF(is_active = 1, 0, 1)
    WHERE id = ?
");
$stmt->execute([$id]);

header('Location: themes.php');
exit;
