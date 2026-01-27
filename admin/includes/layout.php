<?php
require_once __DIR__ . '/auth.php';
require_once BASE_PATH . '/config/constants.php';

$page_title = $page_title ?? 'Admin Panel';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="admin.css">
    <style>/* =====================
   Root Variables
===================== */
:root {
    --sidebar-width: 260px;

    --bg-sidebar: #0f172a;
    --bg-main: #f5f7fb;
    --bg-header: #ffffff;

    --primary: #2563eb;
    --danger: #f87171;

    --text-light: #cbd5f5;
    --text-muted: #94a3b8;
    --text-dark: #0f172a;

    --radius: 10px;
    --transition: 0.2s ease;
}

/* =====================
   Reset
===================== */
*,
*::before,
*::after {
    box-sizing: border-box;
}

html, body {
    margin: 0;
    height: 100%;
    font-family: 'Inter', sans-serif;
    background: var(--bg-main);
    color: var(--text-dark);
}

/* =====================
   Layout
===================== */
.admin-layout {
    display: grid;
    grid-template-columns: var(--sidebar-width) 1fr;
    min-height: 100vh;
}

/* =====================
   Sidebar
===================== */
.sidebar {
    background: var(--bg-sidebar);
    color: var(--text-light);
    display: flex;
    flex-direction: column;
}

/* Sidebar header */
.sidebar-header {
    height: 84px;
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 0 20px;
    font-size: 1.1rem;
    font-weight: 700;
    border-bottom: 1px solid rgba(255,255,255,0.08);
}

/* Navigation */
.sidebar-nav {
    flex: 1;
    padding: 16px 12px;
}

.sidebar-nav a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 14px;
    margin-bottom: 6px;
    border-radius: var(--radius);
    color: var(--text-light);
    text-decoration: none;
    transition: background var(--transition);
}

.sidebar-nav a i {
    width: 18px;
    text-align: center;
}

.sidebar-nav a:hover {
    background: rgba(255,255,255,0.08);
}

.sidebar-nav a.active {
    background: var(--primary);
    color: #ffffff;
}

/* Sidebar footer */
.sidebar-footer {
    padding: 16px;
    border-top: 1px solid rgba(255,255,255,0.08);
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.sidebar-footer .user strong {
    display: block;
    font-size: 0.9rem;
}

.sidebar-footer .user small {
    font-size: 0.75rem;
    color: var(--text-muted);
}

.sidebar-footer .logout {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.85rem;
    color: var(--danger);
    text-decoration: none;
}

/* =====================
   Main Area
===================== */
.main {
    display: flex;
    flex-direction: column;
    min-width: 0;
}

/* =====================
   Header
===================== */
.header {
    background: var(--bg-header);
    min-height: 84px;
    padding: 16px 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #e5e7eb;
}

.header h1 {
    margin: 0;
    font-size: 1.35rem;
    font-weight: 600;
}

/* Header actions */
.header-actions {
    display: flex;
    align-items: center;
    gap: 20px;
    font-size: 1.2rem;
    color: #64748b;
    cursor: pointer;
}

/* =====================
   Content
===================== */
.content {
    padding: 24px;
    flex: 1;
}

/* =====================
   Dashboard (Example)
===================== */
.dashboard h2 {
    margin: 0;
    font-size: 1.4rem;
    font-weight: 600;
}

.dashboard p {
    margin-top: 4px;
    font-size: 0.9rem;
    color: #64748b;
}

/* =====================
   Responsive (Safe)
===================== */
@media (max-width: 900px) {
    .admin-layout {
        grid-template-columns: 80px 1fr;
    }

    .sidebar-header span,
    .sidebar-nav span,
    .sidebar-footer .user {
        display: none;
    }

    .sidebar-nav a {
        justify-content: center;
    }
}
</style>
</head>
<body>

<div class="admin-layout">
