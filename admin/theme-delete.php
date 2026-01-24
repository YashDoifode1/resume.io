<?php
require_once "includes/auth.php";
require_once "../config/database.php";

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM themes WHERE id=?");
$stmt->execute([$id]);

header("Location: themes.php");
exit;
