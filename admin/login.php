<?php
require_once "../config/constants.php";

// Redirect if already logged in
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}

// Generate CSRF token on page load
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
:root {
    --primary:#2563eb;
    --bg:#f4f6f9;
    --card:#fff;
    --text:#1f2937;
    --muted:#6b7280;
    --border:#e5e7eb;
    --error:#dc2626;
}
*{box-sizing:border-box;font-family:system-ui,Arial}
body{
    margin:0;min-height:100vh;
    display:flex;align-items:center;justify-content:center;
    background:var(--bg)
}
.card{
    width:100%;max-width:420px;
    background:var(--card);
    padding:32px;border-radius:12px;
    box-shadow:0 20px 40px rgba(0,0,0,.08);
    border:1px solid var(--border)
}
h1{text-align:center;margin:0;font-size:24px}
p{text-align:center;color:var(--muted);font-size:14px}
.group{margin-top:16px}
label{display:block;font-size:14px;margin-bottom:6px}
input{
    width:100%;padding:12px;
    border-radius:8px;border:1px solid var(--border)
}
button{
    width:100%;margin-top:20px;
    padding:12px;border:none;border-radius:8px;
    background:var(--primary);color:#fff;
    font-size:15px;font-weight:600;cursor:pointer
}
.error{
    background:#fee2e2;color:var(--error);
    padding:12px;border-radius:8px;
    margin-bottom:16px;text-align:center
}
.footer{
    text-align:center;margin-top:16px;
    font-size:13px;color:var(--muted)
}
.footer a{color:var(--primary);text-decoration:none}
</style>
</head>
<body>

<div class="card">
    <h1>Admin Login</h1>
    <p>Access the admin panel</p>

    <?php if (isset($_GET['error'])): ?>
        <div class="error"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <form method="POST" action="login-action.php">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

        <div class="group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit">Login</button>
    </form>

    <div class="footer">
        <a href="../index.php">← Back to Website</a>
    </div>
</div>

</body>
</html>
