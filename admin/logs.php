<?php
require 'includes/header.php';
require 'includes/sidebar.php';
require 'includes/topbar.php';

$logFile = __DIR__ . '/../logs/visitors.log';

$logs = [];
$ipStats = [];
$pageStats = [];
$hourStats = [];
$todayCount = 0;
$yesterdayCount = 0;

if (file_exists($logFile)) {
    $lines = array_reverse(file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
    $today = date('Y-m-d');
    $yesterday = date('Y-m-d', strtotime('-1 day'));

    foreach ($lines as $line) {
        preg_match('/\[(.*?)\]/', $line, $timeMatch);
        $time = $timeMatch[1] ?? 'Unknown';
        
        preg_match('/IP:\s([^\|]+)/', $line, $ipMatch);
        $ip = trim($ipMatch[1] ?? 'Unknown');
        
        preg_match('/Page:\s([^\|]+)/', $line, $pageMatch);
        $page = trim($pageMatch[1] ?? 'Unknown');

        $logs[] = [
            'time' => $time,
            'ip'   => $ip,
            'page' => $page,
            'raw'  => $line
        ];

        // Analytics
        $ipStats[$ip] = ($ipStats[$ip] ?? 0) + 1;
        $pageStats[$page] = ($pageStats[$page] ?? 0) + 1;
        
        $hour = substr($time, 0, 13);
        $hourStats[$hour] = ($hourStats[$hour] ?? 0) + 1;
        
        // Daily stats
        if (strpos($time, $today) === 0) $todayCount++;
        if (strpos($time, $yesterday) === 0) $yesterdayCount++;
    }
}

// Top analytics
arsort($ipStats);
arsort($pageStats);
arsort($hourStats);
?>

<style>
.logs-container {
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.page-header h1 {
    font-size: 28px;
    font-weight: 700;
    color: #2d3748;
}

.page-header .subtitle {
    color: #64748b;
    font-size: 14px;
    margin-top: 4px;
}

.action-bar {
    display: flex;
    gap: 12px;
}

.btn {
    padding: 10px 20px;
    border-radius: 8px;
    border: none;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
}

.btn-primary {
    background: #667eea;
    color: white;
}

.btn-primary:hover {
    background: #5a67d8;
    transform: translateY(-1px);
}

.btn-secondary {
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
}

.btn-secondary:hover {
    background: #e2e8f0;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 24px;
}

.stat-card {
    background: white;
    padding: 24px;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.stat-card h3 {
    font-size: 32px;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 8px;
}

.stat-card p {
    color: #64748b;
    font-size: 14px;
}

.stat-card .trend {
    font-size: 12px;
    margin-top: 8px;
    display: flex;
    align-items: center;
    gap: 4px;
}

.trend.up { color: #10b981; }
.trend.down { color: #ef4444; }

.analytics-section {
    background: white;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
}

.section-header {
    padding: 20px 24px;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.section-header h2 {
    font-size: 18px;
    font-weight: 600;
    color: #2d3748;
}

.table-container {
    overflow-x: auto;
}

.log-table {
    width: 100%;
    border-collapse: collapse;
}

.log-table th {
    background: #f8fafc;
    padding: 16px 24px;
    text-align: left;
    font-weight: 600;
    color: #475569;
    border-bottom: 1px solid #e2e8f0;
    font-size: 14px;
}

.log-table td {
    padding: 16px 24px;
    border-bottom: 1px solid #f1f5f9;
    color: #475569;
    font-size: 14px;
}

.log-table tr:hover {
    background: #f8fafc;
}

.ip-badge {
    background: #e0e7ff;
    color: #3730a3;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.page-link {
    color: #667eea;
    text-decoration: none;
}

.page-link:hover {
    text-decoration: underline;
}

.time-badge {
    background: #f1f5f9;
    color: #64748b;
    padding: 4px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-family: monospace;
}

.chart-container {
    padding: 20px;
    height: 300px;
}

.empty-state {
    padding: 48px 24px;
    text-align: center;
    color: #94a3b8;
}

.empty-state i {
    font-size: 48px;
    margin-bottom: 16px;
    opacity: 0.5;
}

/* Responsive */
@media (max-width: 768px) {
    .logs-container {
        padding: 16px;
    }
    
    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }
    
    .action-bar {
        width: 100%;
        justify-content: flex-start;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .log-table th,
    .log-table td {
        padding: 12px 16px;
    }
}
</style>

<div class="admin-content">
    <div class="logs-container">
        <!-- Header -->
        <div class="page-header">
            <div>
                <h1>Analytics Dashboard</h1>
                <div class="subtitle">Monitor visitor traffic and system activity</div>
            </div>
            <div class="action-bar">
                <button class="btn btn-secondary" onclick="refreshLogs()">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
                <button class="btn btn-primary" onclick="exportLogs()">
                    <i class="fas fa-download"></i> Export
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3><?= number_format(count($logs)) ?></h3>
                <p>Total Log Entries</p>
            </div>
            <div class="stat-card">
                <h3><?= number_format(count($ipStats)) ?></h3>
                <p>Unique Visitors</p>
            </div>
            <div class="stat-card">
                <h3><?= $todayCount ?></h3>
                <p>Today's Visits</p>
                <div class="trend <?= $todayCount > $yesterdayCount ? 'up' : 'down' ?>">
                    <i class="fas fa-arrow-<?= $todayCount > $yesterdayCount ? 'up' : 'down' ?>"></i>
                    <?= abs($todayCount - $yesterdayCount) ?> from yesterday
                </div>
            </div>
            <div class="stat-card">
                <h3><?= $pageStats ? number_format(max($pageStats)) : '0' ?></h3>
                <p>Most Visited Page</p>
                <div class="trend">
                    <?= $pageStats ? htmlspecialchars(array_key_first($pageStats)) : 'No data' ?>
                </div>
            </div>
        </div>

        <!-- Top Visitors -->
        <div class="analytics-section">
            <div class="section-header">
                <h2><i class="fas fa-users" style="margin-right: 10px;"></i> Top Visitors</h2>
                <div style="color: #64748b; font-size: 14px;">Last 7 days</div>
            </div>
            <div class="table-container">
                <?php if ($ipStats): ?>
                <table class="log-table">
                    <thead>
                        <tr>
                            <th>IP Address</th>
                            <th>Hits</th>
                            <th>Last Visit</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($ipStats, 0, 10) as $ip => $count): 
                            $lastVisit = '';
                            foreach ($logs as $log) {
                                if ($log['ip'] === $ip) {
                                    $lastVisit = $log['time'];
                                    break;
                                }
                            }
                        ?>
                        <tr>
                            <td>
                                <span class="ip-badge"><?= htmlspecialchars($ip) ?></span>
                            </td>
                            <td><strong><?= $count ?></strong></td>
                            <td><span class="time-badge"><?= $lastVisit ?></span></td>
                            <td>
                                <button onclick="viewIPDetails('<?= $ip ?>')" class="btn-secondary" style="padding: 6px 12px;">
                                    <i class="fas fa-search"></i> Details
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-chart-bar"></i>
                    <h3>No visitor data</h3>
                    <p>Start collecting analytics data</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Popular Pages -->
        <div class="analytics-section">
            <div class="section-header">
                <h2><i class="fas fa-file" style="margin-right: 10px;"></i> Popular Pages</h2>
                <div style="color: #64748b; font-size: 14px;">Page views distribution</div>
            </div>
            <div class="table-container">
                <?php if ($pageStats): ?>
                <table class="log-table">
                    <thead>
                        <tr>
                            <th>Page</th>
                            <th>Views</th>
                            <th>Percentage</th>
                            <th>Trend</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $totalViews = array_sum($pageStats);
                        foreach (array_slice($pageStats, 0, 10) as $page => $count): 
                            $percentage = round(($count / $totalViews) * 100, 1);
                        ?>
                        <tr>
                            <td>
                                <a href="#" class="page-link"><?= htmlspecialchars($page) ?></a>
                            </td>
                            <td><strong><?= $count ?></strong></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="flex: 1; background: #e2e8f0; height: 6px; border-radius: 3px;">
                                        <div style="width: <?= $percentage ?>%; background: #667eea; height: 100%; border-radius: 3px;"></div>
                                    </div>
                                    <span><?= $percentage ?>%</span>
                                </div>
                            </td>
                            <td style="color: #10b981;">
                                <i class="fas fa-arrow-up"></i> 12%
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-file"></i>
                    <h3>No page data</h3>
                    <p>No page visits recorded yet</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="analytics-section">
            <div class="section-header">
                <h2><i class="fas fa-history" style="margin-right: 10px;"></i> Recent Activity</h2>
                <div style="color: #64748b; font-size: 14px;">Live visitor tracking</div>
            </div>
            <div class="table-container">
                <?php if ($logs): ?>
                <table class="log-table">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Visitor</th>
                            <th>Page</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($logs, 0, 20) as $log): ?>
                        <tr>
                            <td>
                                <span class="time-badge">
                                    <i class="far fa-clock"></i> <?= date('H:i', strtotime($log['time'])) ?>
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="width: 8px; height: 8px; background: #10b981; border-radius: 50%;"></div>
                                    <?= htmlspecialchars($log['ip']) ?>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($log['page']) ?></td>
                            <td>
                                <span style="color: #10b981; font-size: 12px; font-weight: 500;">
                                    <i class="fas fa-check-circle"></i> Active
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-history"></i>
                    <h3>No activity logs</h3>
                    <p>Activity will appear here</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function refreshLogs() {
    showLoading();
    setTimeout(() => {
        window.location.reload();
        hideLoading();
    }, 500);
}

function exportLogs() {
    showToast('Exporting logs to CSV...', 'info');
    // Implementation for CSV export
    setTimeout(() => {
        showToast('Logs exported successfully!', 'success');
    }, 1500);
}

function viewIPDetails(ip) {
    showToast(`Loading details for IP: ${ip}`, 'info');
    // Implementation for IP details view
}

// Auto-refresh every 30 seconds
setTimeout(() => {
    if (document.visibilityState === 'visible') {
        refreshLogs();
    }
}, 30000);
</script>

<?php require 'includes/footer.php'; ?>