<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$page_title = 'Admin Dashboard - F24Tech';
include '../includes/admin-header.php';
?>

<div class="min-h-screen bg-gray-50 pt-16">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
            <p class="text-gray-600">Manage your website content and analytics</p>
        </div>
    </div>

    <!-- Dashboard Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <?php
            include '../config/database.php';
            
            // Get stats
            $total_projects = DB::query("SELECT COUNT(*) as count FROM projects")->fetch()['count'] ?? 0;
            $total_contacts = DB::query("SELECT COUNT(*) as count FROM contact_submissions")->fetch()['count'] ?? 0;
            $total_newsletter = DB::query("SELECT COUNT(*) as count FROM newsletter_subscriptions WHERE status = 'active'")->fetch()['count'] ?? 0;
            $recent_views = DB::query("SELECT COUNT(*) as count FROM page_views WHERE view_time >= DATE_SUB(NOW(), INTERVAL 30 DAY)")->fetch()['count'] ?? 0;
            ?>
            
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Total Projects</p>
                        <p class="text-3xl font-bold text-gray-900"><?php echo $total_projects; ?></p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Contact Submissions</p>
                        <p class="text-3xl font-bold text-gray-900"><?php echo $total_contacts; ?></p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-lg">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Newsletter Subscribers</p>
                        <p class="text-3xl font-bold text-gray-900"><?php echo $total_newsletter; ?></p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-lg">
                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Page Views (30d)</p>
                        <p class="text-3xl font-bold text-gray-900"><?php echo $recent_views; ?></p>
                    </div>
                    <div class="bg-orange-100 p-3 rounded-lg">
                        <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <a href="add-project.php" class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 group">
                <div class="bg-blue-500 w-16 h-16 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-blue-600 transition-colors">
                    Add New Project
                </h3>
                <p class="text-gray-600 leading-relaxed">
                    Add a new project to the portfolio with details, images, and case study information.
                </p>
            </a>

            <a href="manage-portfolio.php" class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 group">
                <div class="bg-green-500 w-16 h-16 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-blue-600 transition-colors">
                    Manage Portfolio
                </h3>
                <p class="text-gray-600 leading-relaxed">
                    View, edit, and delete existing projects in the portfolio.
                </p>
            </a>

            <a href="analytics.php" class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 group">
                <div class="bg-purple-500 w-16 h-16 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-blue-600 transition-colors">
                    Analytics
                </h3>
                <p class="text-gray-600 leading-relaxed">
                    View website analytics, project views, and contact form submissions.
                </p>
            </a>

            <a href="manage-contacts.php" class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 group">
                <div class="bg-orange-500 w-16 h-16 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-blue-600 transition-colors">
                    Manage Contacts
                </h3>
                <p class="text-gray-600 leading-relaxed">
                    View and manage contact form submissions and leads.
                </p>
            </a>

            <a href="settings.php" class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 group">
                <div class="bg-gray-500 w-16 h-16 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-blue-600 transition-colors">
                    Settings
                </h3>
                <p class="text-gray-600 leading-relaxed">
                    Configure website settings and admin preferences.
                </p>
            </a>

            <a href="logout.php" class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 group">
                <div class="bg-red-500 w-16 h-16 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-blue-600 transition-colors">
                    Logout
                </h3>
                <p class="text-gray-600 leading-relaxed">
                    Sign out of the admin panel.
                </p>
            </a>
        </div>

        <!-- Recent Activity -->
        <div class="mt-12 grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Contacts -->
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Recent Contacts</h3>
                <?php
                $recent_contacts = DB::query("SELECT * FROM contact_submissions ORDER BY created_at DESC LIMIT 5")->fetchAll();
                if ($recent_contacts): ?>
                    <div class="space-y-4">
                        <?php foreach ($recent_contacts as $contact): ?>
                            <div class="border-l-4 border-blue-500 pl-4">
                                <div class="flex items-center justify-between">
                                    <p class="font-medium text-gray-900"><?php echo htmlspecialchars($contact['name']); ?></p>
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                        <?php echo ucfirst($contact['status'] ?? 'new'); ?>
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600"><?php echo htmlspecialchars($contact['email']); ?></p>
                                <p class="text-xs text-gray-400">
                                    <?php echo date('M j, Y', strtotime($contact['created_at'])); ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500">No contacts yet.</p>
                <?php endif; ?>
            </div>

            <!-- Recent Projects -->
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Recent Projects</h3>
                <?php
                $recent_projects = DB::query("SELECT * FROM projects ORDER BY updated_at DESC LIMIT 5")->fetchAll();
                if ($recent_projects): ?>
                    <div class="space-y-4">
                        <?php foreach ($recent_projects as $project): ?>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-900"><?php echo htmlspecialchars($project['title']); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($project['client'] ?? 'No client'); ?></p>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full <?php echo $project['status'] === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                                    <?php echo ucfirst($project['status'] ?? 'draft'); ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500">No projects yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/admin-footer.php'; ?>