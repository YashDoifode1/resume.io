<?php
/**
 * Admin Settings Page (Themed)
 * Allows admin to edit .env configuration safely
 */

session_start();

$envFile = __DIR__ . '/../.env';

/* ===============================
   Load .env
=============================== */
function loadEnv(string $path): array {
    $data = [];
    if (!file_exists($path)) return $data;

    foreach (file($path, FILE_IGNORE_NEW_LINES) as $line) {
        if ($line === '' || str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
        [$k, $v] = explode('=', $line, 2);
        $data[trim($k)] = trim($v, "\"'");
    }
    return $data;
}

/* ===============================
   Save .env
=============================== */
function saveEnv(string $path, array $values): void {
    $content = <<<ENV
APP_NAME="{$values['APP_NAME']}"
APP_ENV={$values['APP_ENV']}
APP_DEBUG={$values['APP_DEBUG']}
BASE_URL={$values['BASE_URL']}

DB_HOST={$values['DB_HOST']}
DB_NAME={$values['DB_NAME']}
DB_USER={$values['DB_USER']}
DB_PASS={$values['DB_PASS']}

CONTACT_EMAIL={$values['CONTACT_EMAIL']}
CONTACT_PHONE="{$values['CONTACT_PHONE']}"
CONTACT_ADDRESS="{$values['CONTACT_ADDRESS']}"

ENABLE_ANALYTICS={$values['ENABLE_ANALYTICS']}
ENABLE_SOCIAL_SHARE={$values['ENABLE_SOCIAL_SHARE']}
ENABLE_DOWNLOAD_TRACKING={$values['ENABLE_DOWNLOAD_TRACKING']}
ENV;

    file_put_contents($path, $content);
}

/* ===============================
   Handle Save
=============================== */
$env = loadEnv($envFile);
$saved = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $k => $v) {
        $env[$k] = trim($v);
    }
    saveEnv($envFile, $env);
    $saved = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Settings</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<style>
/* ===== CORE ===== */
:root{
    --bg:#f4f6fb;--panel:#fff;--border:#e5e7eb;
    --primary:#2563eb;--success:#16a34a;
    --text:#1f2937;--muted:#6b7280;
    --sidebar:#0f172a
}
*{box-sizing:border-box}
body{margin:0;font-family:Inter,sans-serif;background:var(--bg);color:var(--text)}

/* ===== LAYOUT ===== */
.admin{display:flex;min-height:100vh}
.sidebar{
    width:260px;background:var(--sidebar);color:#cbd5f5;
    display:flex;flex-direction:column
}
.main{flex:1;display:flex;flex-direction:column}

/* ===== SIDEBAR ===== */
.sidebar h2{padding:20px;margin:0;font-size:18px;border-bottom:1px solid rgba(255,255,255,.08)}
.sidebar a{
    padding:14px 20px;color:#cbd5f5;text-decoration:none;
    display:flex;gap:12px
}
.sidebar a.active,.sidebar a:hover{background:var(--primary);color:#fff}

/* ===== HEADER ===== */
.header{
    height:72px;background:#fff;border-bottom:1px solid var(--border);
    display:flex;align-items:center;justify-content:space-between;
    padding:0 28px
}

/* ===== CONTENT ===== */
.content{padding:28px}

/* ===== FORM ===== */
.panel{
    background:#fff;border:1px solid var(--border);
    border-radius:10px;padding:24px
}
.panel h2{margin-top:0}
.grid{
    display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
    gap:16px
}
label{font-size:13px;color:var(--muted)}
input,select{
    width:100%;padding:10px;border-radius:6px;
    border:1px solid var(--border)
}
button{
    background:var(--primary);color:#fff;border:none;
    padding:10px 18px;border-radius:8px;cursor:pointer
}
.success{
    background:#dcfce7;color:var(--success);
    padding:12px;border-radius:8px;margin-bottom:16px
}
</style>
</head>

<body>

<div class="admin">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <h2>Admin Panel</h2>
        <a href="dashboard.php"><i class="fas fa-chart-line"></i>Dashboard</a>
        <a href="themes.php"><i class="fas fa-palette"></i>Themes</a>
        <a class="active" href="settings.php"><i class="fas fa-gear"></i>Settings</a>
    </aside>

    <!-- MAIN -->
    <div class="main">

        <header class="header">
            <h1>Settings</h1>
            <i class="fas fa-user-circle"></i>
        </header>

        <div class="content">

            <?php if ($saved): ?>
                <div class="success">Settings saved successfully.</div>
            <?php endif; ?>

            <form method="post" class="panel">

                <h2>Application</h2>
                <div class="grid">
                    <div>
                        <label>App Name</label>
                        <input name="APP_NAME" value="<?= htmlspecialchars($env['APP_NAME'] ?? '') ?>">
                    </div>
                    <div>
                        <label>Environment</label>
                        <select name="APP_ENV">
                            <option value="local">Local</option>
                            <option value="production">Production</option>
                        </select>
                    </div>
                    <div>
                        <label>Debug</label>
                        <select name="APP_DEBUG">
                            <option value="true">True</option>
                            <option value="false">False</option>
                        </select>
                    </div>
                </div>

                <h2>Database</h2>
                <div class="grid">
                    <input name="DB_HOST" placeholder="Host" value="<?= $env['DB_HOST'] ?? '' ?>">
                    <input name="DB_NAME" placeholder="Database" value="<?= $env['DB_NAME'] ?? '' ?>">
                    <input name="DB_USER" placeholder="User" value="<?= $env['DB_USER'] ?? '' ?>">
                    <input name="DB_PASS" placeholder="Password" value="<?= $env['DB_PASS'] ?? '' ?>">
                </div>

                <h2>Contact</h2>
                <div class="grid">
                    <input name="CONTACT_EMAIL" placeholder="Email" value="<?= $env['CONTACT_EMAIL'] ?? '' ?>">
                    <input name="CONTACT_PHONE" placeholder="Phone" value="<?= $env['CONTACT_PHONE'] ?? '' ?>">
                    <input name="CONTACT_ADDRESS" placeholder="Address" value="<?= $env['CONTACT_ADDRESS'] ?? '' ?>">
                </div>

                <h2>Features</h2>
                <div class="grid">
                    <select name="ENABLE_ANALYTICS"><option>true</option><option>false</option></select>
                    <select name="ENABLE_SOCIAL_SHARE"><option>true</option><option>false</option></select>
                    <select name="ENABLE_DOWNLOAD_TRACKING"><option>true</option><option>false</option></select>
                </div>

                <br>
                <button type="submit">Save Settings</button>

            </form>

        </div>
    </div>
</div>

</body>
</html>
