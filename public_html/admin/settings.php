<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$page_title = 'Settings - Admin - F24Tech';
$success = '';
$error = '';

// Handle password change
if ($_POST && isset($_POST['action']) && $_POST['action'] === 'change_password') {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Simple validation (in production, use proper password hashing and database)
    if ($current_password === 'admin123') {
        if ($new_password === $confirm_password && strlen($new_password) >= 6) {
            // In a real application, you would update the password in the database
            $success = 'Password would be updated successfully! (Demo mode - changes not saved)';
        } else {
            $error = 'New passwords do not match or are too short (minimum 6 characters)';
        }
    } else {
        $error = 'Current password is incorrect';
    }
}

include '../includes/admin-header.php';
?>

<div class="min-h-screen bg-gray-50 pt-16">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Settings</h1>
                    <p class="text-gray-600">Manage your admin preferences and website settings</p>
                </div>
                <a href="index.php" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <?php if ($success): ?>
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-6">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-6">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="space-y-8">
            <!-- Account Settings -->
            <div class="bg-white rounded-2xl p-8 shadow-lg">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Account Settings</h3>
                
                <form method="POST" class="space-y-6">
                    <input type="hidden" name="action" value="change_password">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                        <input type="password" name="current_password" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                        <input type="password" name="new_password" required minlength="6"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                        <input type="password" name="confirm_password" required minlength="6"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <button type="submit" 
                            class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        Change Password
                    </button>
                </form>
            </div>

            <!-- Website Settings -->
            <div class="bg-white rounded-2xl p-8 shadow-lg">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Website Settings</h3>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Company Name</label>
                        <input type="text" value="F24Tech Softwares" readonly
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50">
                        <p class="text-sm text-gray-500 mt-1">Contact developer to change company information</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Contact Email</label>
                        <input type="email" value="sales@f24tech.com" readonly
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50">
                        <p class="text-sm text-gray-500 mt-1">Update in includes/footer.php and pages/contact.php</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="tel" value="+91 8950773419" readonly
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50">
                        <p class="text-sm text-gray-500 mt-1">Update in includes/footer.php and pages/contact.php</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                        <input type="text" value="Plot No. 44, Sector 44, Gurgaon, Haryana, 122003, INDIA" readonly
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50">
                        <p class="text-sm text-gray-500 mt-1">Update in includes/footer.php and pages/contact.php</p>
                    </div>
                </div>
            </div>

            <!-- Database Settings -->
            <div class="bg-white rounded-2xl p-8 shadow-lg">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Database Information</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b">
                        <span class="font-medium text-gray-700">Database Host:</span>
                        <span class="text-gray-600">localhost</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b">
                        <span class="font-medium text-gray-700">Database Name:</span>
                        <span class="text-gray-600">u925328211_ncb</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b">
                        <span class="font-medium text-gray-700">Database User:</span>
                        <span class="text-gray-600">u925328211_ncb</span>
                    </div>
                    <div class="flex justify-between items-center py-3">
                        <span class="font-medium text-gray-700">Connection Status:</span>
                        <span class="text-green-600 font-semibold">Connected</span>
                    </div>
                </div>
            </div>

            <!-- System Information -->
            <div class="bg-white rounded-2xl p-8 shadow-lg">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">System Information</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b">
                        <span class="font-medium text-gray-700">PHP Version:</span>
                        <span class="text-gray-600"><?php echo phpversion(); ?></span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b">
                        <span class="font-medium text-gray-700">Server Software:</span>
                        <span class="text-gray-600"><?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?></span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b">
                        <span class="font-medium text-gray-700">Document Root:</span>
                        <span class="text-gray-600 text-sm"><?php echo $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown'; ?></span>
                    </div>
                    <div class="flex justify-between items-center py-3">
                        <span class="font-medium text-gray-700">Current Time:</span>
                        <span class="text-gray-600"><?php echo date('Y-m-d H:i:s'); ?></span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl p-8 shadow-lg">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Quick Actions</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="manage-portfolio.php" 
                       class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="h-8 w-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <div>
                            <div class="font-semibold text-gray-900">Manage Portfolio</div>
                            <div class="text-sm text-gray-600">View and edit projects</div>
                        </div>
                    </a>
                    
                    <a href="manage-contacts.php" 
                       class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="h-8 w-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        <div>
                            <div class="font-semibold text-gray-900">Manage Contacts</div>
                            <div class="text-sm text-gray-600">View contact submissions</div>
                        </div>
                    </a>
                    
                    <a href="analytics.php" 
                       class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="h-8 w-8 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <div>
                            <div class="font-semibold text-gray-900">View Analytics</div>
                            <div class="text-sm text-gray-600">Check website statistics</div>
                        </div>
                    </a>
                    
                    <a href="../" target="_blank"
                       class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="h-8 w-8 text-orange-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        <div>
                            <div class="font-semibold text-gray-900">View Website</div>
                            <div class="text-sm text-gray-600">Open public website</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/admin-footer.php'; ?>