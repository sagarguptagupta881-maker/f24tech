<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

include '../config/database.php';

$page_title = 'Analytics - Admin - F24Tech';

// Get date range
$date_range = $_GET['range'] ?? '30days';
$custom_start = $_GET['start'] ?? '';
$custom_end = $_GET['end'] ?? '';

// Calculate date range
switch ($date_range) {
    case 'today':
        $start_date = date('Y-m-d');
        $end_date = date('Y-m-d');
        break;
    case '7days':
        $start_date = date('Y-m-d', strtotime('-7 days'));
        $end_date = date('Y-m-d');
        break;
    case '30days':
        $start_date = date('Y-m-d', strtotime('-30 days'));
        $end_date = date('Y-m-d');
        break;
    case 'custom':
        $start_date = $custom_start ?: date('Y-m-d', strtotime('-30 days'));
        $end_date = $custom_end ?: date('Y-m-d');
        break;
    default:
        $start_date = date('Y-m-d', strtotime('-30 days'));
        $end_date = date('Y-m-d');
}

// Get analytics data
try {
    // Page views
    $page_views = DB::query("
        SELECT COUNT(*) as total_views, COUNT(DISTINCT session_id) as unique_visitors
        FROM page_views 
        WHERE DATE(view_time) BETWEEN ? AND ?
    ", [$start_date, $end_date])->fetch();

    // Top pages
    $top_pages = DB::query("
        SELECT page_url, page_title, COUNT(*) as views, AVG(time_on_page) as avg_time
        FROM page_views 
        WHERE DATE(view_time) BETWEEN ? AND ?
        GROUP BY page_url, page_title
        ORDER BY views DESC
        LIMIT 10
    ", [$start_date, $end_date])->fetchAll();

    // Contact submissions
    $contact_stats = DB::query("
        SELECT COUNT(*) as total_contacts
        FROM contact_submissions 
        WHERE DATE(created_at) BETWEEN ? AND ?
    ", [$start_date, $end_date])->fetch();

    // Newsletter subscriptions
    $newsletter_stats = DB::query("
        SELECT COUNT(*) as total_subscriptions
        FROM newsletter_subscriptions 
        WHERE DATE(subscribed_at) BETWEEN ? AND ?
    ", [$start_date, $end_date])->fetch();

    // Recent contacts
    $recent_contacts = DB::query("
        SELECT * FROM contact_submissions 
        ORDER BY created_at DESC 
        LIMIT 10
    ")->fetchAll();

    // Device breakdown (mock data since we don't have real analytics)
    $device_breakdown = [
        ['device_type' => 'desktop', 'count' => 60, 'percentage' => 60],
        ['device_type' => 'mobile', 'count' => 35, 'percentage' => 35],
        ['device_type' => 'tablet', 'count' => 5, 'percentage' => 5]
    ];

} catch (Exception $e) {
    $error = 'Error fetching analytics: ' . $e->getMessage();
}

include '../includes/admin-header.php';
?>

<div class="min-h-screen bg-gray-50 pt-16">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Analytics Dashboard</h1>
                    <p class="text-gray-600">Track website performance and user behavior</p>
                </div>
                <a href="index.php" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Date Range Selector -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <form method="GET" class="flex flex-wrap gap-4 items-center">
                <select name="range" onchange="toggleCustomDates(this.value)" 
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="today" <?php echo $date_range === 'today' ? 'selected' : ''; ?>>Today</option>
                    <option value="7days" <?php echo $date_range === '7days' ? 'selected' : ''; ?>>Last 7 Days</option>
                    <option value="30days" <?php echo $date_range === '30days' ? 'selected' : ''; ?>>Last 30 Days</option>
                    <option value="custom" <?php echo $date_range === 'custom' ? 'selected' : ''; ?>>Custom Range</option>
                </select>
                
                <div id="custom-dates" style="<?php echo $date_range === 'custom' ? '' : 'display: none;'; ?>">
                    <input type="date" name="start" value="<?php echo htmlspecialchars($custom_start); ?>" 
                           class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <input type="date" name="end" value="<?php echo htmlspecialchars($custom_end); ?>" 
                           class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Apply
                </button>
            </form>
        </div>
    </div>

    <!-- Analytics Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Page Views</p>
                        <p class="text-3xl font-bold text-gray-900"><?php echo number_format($page_views['total_views'] ?? 0); ?></p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Unique Visitors</p>
                        <p class="text-3xl font-bold text-gray-900"><?php echo number_format($page_views['unique_visitors'] ?? 0); ?></p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-lg">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Contact Submissions</p>
                        <p class="text-3xl font-bold text-gray-900"><?php echo number_format($contact_stats['total_contacts'] ?? 0); ?></p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-lg">
                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Newsletter Signups</p>
                        <p class="text-3xl font-bold text-gray-900"><?php echo number_format($newsletter_stats['total_subscriptions'] ?? 0); ?></p>
                    </div>
                    <div class="bg-orange-100 p-3 rounded-lg">
                        <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Top Pages -->
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Top Pages</h3>
                <?php if ($top_pages): ?>
                    <div class="space-y-4">
                        <?php foreach ($top_pages as $page): ?>
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900"><?php echo htmlspecialchars($page['page_title'] ?: $page['page_url']); ?></p>
                                    <p class="text-sm text-gray-500"><?php echo htmlspecialchars($page['page_url']); ?></p>
                                </div>
                                <div class="text-right ml-4">
                                    <p class="font-semibold text-gray-900"><?php echo number_format($page['views']); ?></p>
                                    <p class="text-sm text-gray-500"><?php echo round($page['avg_time'] ?? 0); ?>s avg</p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500">No page data available for this period.</p>
                <?php endif; ?>
            </div>

            <!-- Device Breakdown -->
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Device Types</h3>
                <div class="space-y-4">
                    <?php foreach ($device_breakdown as $device): ?>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="mr-3 text-gray-600">
                                    <?php if ($device['device_type'] === 'mobile'): ?>
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    <?php elseif ($device['device_type'] === 'tablet'): ?>
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    <?php else: ?>
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    <?php endif; ?>
                                </div>
                                <span class="font-medium text-gray-900 capitalize"><?php echo $device['device_type']; ?></span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-24 bg-gray-200 rounded-full h-2 mr-3">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: <?php echo $device['percentage']; ?>%"></div>
                                </div>
                                <span class="text-sm font-semibold text-gray-900 w-12 text-right"><?php echo $device['percentage']; ?>%</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Recent Contacts -->
        <div class="bg-white rounded-xl p-6 shadow-lg">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Recent Contacts</h3>
            <?php if ($recent_contacts): ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Name</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Email</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Company</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Service</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Date</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($recent_contacts as $contact): ?>
                                <tr>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                        <?php echo htmlspecialchars($contact['name']); ?>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600">
                                        <?php echo htmlspecialchars($contact['email']); ?>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600">
                                        <?php echo htmlspecialchars($contact['company'] ?? 'N/A'); ?>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600">
                                        <?php echo htmlspecialchars($contact['service_interest'] ?? 'N/A'); ?>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600">
                                        <?php echo date('M j, Y', strtotime($contact['created_at'])); ?>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                            <?php echo ucfirst($contact['status'] ?? 'new'); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-gray-500">No contacts found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function toggleCustomDates(value) {
    const customDates = document.getElementById('custom-dates');
    if (value === 'custom') {
        customDates.style.display = 'block';
    } else {
        customDates.style.display = 'none';
    }
}
</script>

<?php include '../includes/admin-footer.php'; ?>